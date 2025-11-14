<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use App\Models\RegistroSesion as Sesion;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SesionKinesiologica extends Component
{
    // Propiedades del paciente y del formulario
    public $paciente;
    public $sesionId;
    public $sesion_nro;
    public $fecha_sesion;
    public $tratamiento_fisiokinetico;
    public $evolucion_sesion;

    // Propiedades de la UI y la data
    public $sesiones;
    public $serieActiva;
    public $nuevaSerie = false;
    public $filtro = 'todas';
    public $limiteSerie = 10; // Límite de sesiones para la alerta visual

    // Listeners para eventos de SweetAlert2
    protected $listeners = [
        'finalizarSerieConfirmada' => 'finalizarSerieConfirmada',
        'guardarSesionConfirmada' => 'guardarSesion', // Flujo normal de confirmación
        'continuarGuardadoForzado' => 'guardarSesion', // Flujo forzado desde alertas de límite
    ];

    protected $rules = [
        'sesion_nro' => 'required|integer',
        'fecha_sesion' => 'required|date',
        'tratamiento_fisiokinetico' => 'nullable|string',
        'evolucion_sesion' => 'nullable|string',
    ];

    protected $validationAttributes = [
        'sesion_nro' => 'Número de Sesión',
        'fecha_sesion' => 'Fecha de Sesión',
    ];

    public function mount(Paciente $paciente)
    {
        Log::info("[MOUNT] Componente SesionKinesiologica montado para Paciente ID: {$paciente->id}");
        $this->paciente = $paciente;
        $this->cargarSesiones();
    }

    /**
     * Propiedad computada para filtrar las sesiones mostradas en la tabla.
     */
    public function getSesionesFiltradasProperty()
    {
        if ($this->filtro === 'activas') {
            return $this->serieActiva;
        }

        if ($this->filtro === 'inactivas') {
            return $this->sesiones->where('firma_paciente_digital', 1);
        }

        return $this->sesiones;
    }

    /**
     * Carga las sesiones del paciente y configura el formulario para la próxima sesión.
     */
    public function cargarSesiones()
    {
        $this->sesiones = Sesion::where('paciente_id', $this->paciente->id)
            ->orderBy('id')
            ->get();

        $this->serieActiva = $this->sesiones->where('firma_paciente_digital', 0);

        // Lógica de autoincremento: Debe basarse en el número de sesión MÁS ALTO de todas las sesiones.
        if ($this->sesiones->count() > 0) {
            // El número de la próxima sesión es +1 del último número de sesión total
            $lastSesionNro = $this->sesiones->max('sesion_nro');
            $this->sesion_nro = $lastSesionNro ? $lastSesionNro + 1 : 1;
        } else {
            // Si es la primera sesión del paciente
            $this->sesion_nro = 1;
        }

        $this->fecha_sesion = Carbon::today()->toDateString();
        $this->reset(['filtro']);
        Log::info("[LOAD] Sesiones cargadas. Activas: {$this->serieActiva->count()}");
    }

    /* -------------------------------------------------
     * FLUJO DE GUARDADO CON CONFIRMACIÓN (SweetAlert2)
     * Lógica de ALERTA DE LÍMITE RESTAURADA
     ------------------------------------------------- */
    public function confirmarGuardarSesion()
    {
        Log::info("[GUARDAR_CONFIRM] Iniciando confirmación de guardado. Sesion ID: {$this->sesionId}");

        try {
            // 1. Validar datos
            $validatedData = $this->validate();

            // 2. Lógica de ALERTA DE LÍMITE (solo si es una *nueva* sesión, no una edición)
            if (is_null($this->sesionId)) {
                $activas = $this->serieActiva->count();
                $limite = $this->limiteSerie;

                if ($activas === $limite - 1) {
                    // Advertencia de límite inminente (ej. 9/10)
                    Log::info("[GUARDAR_CONFIRM] Límite inminente ({$activas}/{$limite}). Despachando alertaLimite.");
                    return $this->dispatch('alertaLimite', [
                        'title' => '¡Atención!',
                        'text' => "Estás a punto de registrar la sesión N°{$this->sesion_nro}, la última sesión de la serie ({$limite}/{$limite}). ¿Deseas continuar guardando?"
                    ]);
                }

                if ($activas >= $limite) {
                    // Límite alcanzado o superado (ej. 10/10 o más)
                    Log::warning("[GUARDAR_CONFIRM] Límite alcanzado ({$activas}/{$limite}). Despachando alertaContinuar.");
                    return $this->dispatch('alertaContinuar', [
                        'title' => '¡Límite de Sesiones!',
                        'text' => "Ya tienes {$activas} sesiones activas (límite: {$limite}). ¿Quieres guardar esta sesión como extra o finalizar la serie ahora?"
                    ]);
                }
            }

            // 3. Si no hay alerta de límite (o es edición), continuar con la confirmación normal
            Log::info("[GUARDAR_CONFIRM] Datos validados correctamente. Despachando confirmación normal.");
            $this->dispatch('confirmarGuardado');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning("[GUARDAR_CONFIRM] Validación fallida: " . json_encode($e->errors()));
            throw $e; // Relanzar la excepción para que Livewire maneje los errores
        }
    }

    // Este método solo se ejecuta si el usuario confirma en SweetAlert (flujo normal o forzado)
    public function guardarSesion()
    {
        // Volvemos a validar por si el usuario editó los datos durante el proceso de confirmación
        $validatedData = $this->validate();

        Log::info("[GUARDAR_FINAL] Confirmación recibida. Ejecutando guardado final.");

        $isUpdate = !is_null($this->sesionId);
        $action = $isUpdate ? 'actualizada' : 'registrada';

        $sesion = Sesion::updateOrCreate(
            ['id' => $this->sesionId],
            [
                'paciente_id' => $this->paciente->id,
                'sesion_nro' => $validatedData['sesion_nro'],
                'fecha_sesion' => $validatedData['fecha_sesion'],
                'tratamiento_fisiokinetico' => $validatedData['tratamiento_fisiokinetico'],
                'evolucion_sesion' => $validatedData['evolucion_sesion'],
                'firma_paciente_digital' => 0
            ]
        );

        Log::info("[GUARDAR_FINAL] Sesión {$action} con ID: {$sesion->id}");

        $this->resetCampos();
        $this->cargarSesiones();

        // Disparar SweetAlert de éxito
        $this->dispatch('sesionGuardada', [
            'title' => '¡Éxito!',
            'text' => "Sesión {$action} correctamente.",
            'icon' => 'success'
        ]);
    }

    /* -------------------------------------------------
     * EDICIÓN Y ELIMINACIÓN
     ------------------------------------------------- */
    public function editarSesion($id)
    {
        Log::info("[EDICIÓN] Iniciando edición de Sesión ID: {$id}");
        $sesion = Sesion::findOrFail($id);

        $this->sesionId = $sesion->id;
        $this->sesion_nro = $sesion->sesion_nro;
        // Se corrige el parseo de fecha para asegurar formato Y-m-d
        $this->fecha_sesion = Carbon::parse($sesion->fecha_sesion)->toDateString();
        $this->tratamiento_fisiokinetico = $sesion->tratamiento_fisiokinetico;
        $this->evolucion_sesion = $sesion->evolucion_sesion;

        $this->dispatch('abrirFormulario');
        Log::info("[EDICIÓN] Campos cargados. Despachando abrirFormulario.");
    }

    public function eliminarSesion($id)
    {
        Log::warning("[ELIMINACIÓN] Eliminando Sesión ID: {$id}");

        try {
            Sesion::findOrFail($id)->delete();
            $this->resetCampos();
            $this->cargarSesiones();

            $this->dispatch('swal', [
                'title' => '¡Eliminada!',
                'text' => 'Sesión eliminada correctamente.',
                'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            Log::error("[ELIMINACIÓN] Error al eliminar Sesión ID {$id}: " . $e->getMessage());
            $this->dispatch('swal', [
                'title' => 'Error',
                'text' => 'No se pudo eliminar la sesión. ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    /* -------------------------------------------------
     * FINALIZAR SERIE – con confirmación SweetAlert2
     ------------------------------------------------- */
    public function finalizarSerie()
    {
        Log::info("[FINALIZAR_CONFIRM] Iniciando confirmación para finalizar serie.");

        $activas = $this->serieActiva->count();

        if ($activas > 0) {
            // Si hay sesiones activas, disparamos la CONFIRMACIÓN SweetAlert
            $this->dispatch('confirmarFinalizarSerie');
        } else {
            // Si NO hay sesiones activas, disparamos la ALERTA INSTANTÁNEA
            $this->dispatch('swal', [
                'title' => 'Atención',
                'text' => 'No existen sesiones activas para finalizar.',
                'icon' => 'info'
            ]);
        }
    }

    public function finalizarSerieConfirmada()
    {
        Log::info("[FINALIZAR_FINAL] Confirmación recibida. Ejecutando finalización de serie.");
        $count = $this->serieActiva->count();

        if ($count > 0) {
            Sesion::where('paciente_id', $this->paciente->id)
                ->where('firma_paciente_digital', 0)
                ->update(['firma_paciente_digital' => 1]);

            Log::info("[FINALIZAR_FINAL] {$count} sesiones marcadas como inactivas.");

            $this->dispatch('sesionGuardada', [
                'title' => '¡Serie Finalizada!',
                'text' => "Todas las sesiones activas han sido marcadas como inactivas.",
                'icon' => 'success'
            ]);
        }


        $this->resetCampos();
        $this->cargarSesiones();
    }

    /**
     * Resetea los campos del formulario de edición/creación, la validación,
     * y recarga las sesiones para obtener el siguiente número consecutivo.
     * Se cambió a PUBLIC para que Livewire pueda llamarlo directamente.
     */
    public function resetCampos(): void
    {
        Log::debug("[RESET] Reseteando campos del formulario.");
        $this->sesionId = null;
        $this->tratamiento_fisiokinetico = null; // null en lugar de '' para consistencia
        $this->evolucion_sesion = null; // null en lugar de '' para consistencia
        $this->resetValidation();
        // Recalculamos el número de sesión y fecha para el próximo registro
        $this->cargarSesiones();
    }

    public function render()
    {
        return view('livewire.kinesiologia.sesion-kinesiologica')
            ->layout('layouts.app');
    }
}
