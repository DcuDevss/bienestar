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
        'guardarSesionConfirmada' => 'guardarSesion',
        'continuarGuardadoForzado' => 'guardarSesion',
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
        // 💡 Inicializa el formulario para la primera sesión
        $this->resetCampos();
    }
    
    // ----------------------------------------------------------------------
    // 🔑 CORRECCIÓN CLAVE: Lógica de Numeración Basada en Sesiones ACTIVAS
    // ----------------------------------------------------------------------

    /**
     * Calcula el número de sesión consecutivo.
     * Si no hay sesiones activas, la próxima sesión es 1, iniciando una nueva serie.
     */
    private function calcularProximaSesionNro(): int
    {
        // 💡 BUSCA EL MÁXIMO NÚMERO DE SESIÓN SÓLO DE LA SERIE ACTIVA (digital = 0)
        $lastSesionNroActiva = Sesion::where('paciente_id', $this->paciente->id)
            ->where('firma_paciente_digital', 0)
            ->max('sesion_nro');

        if ($lastSesionNroActiva) {
            // Si hay activas, continuamos la serie (Ej: si max es 4, devuelve 5)
            return $lastSesionNroActiva + 1;
        }

        // Si no hay activas (serie finalizada), devuelve 1 para iniciar la nueva serie.
        return 1;
    }

    // ----------------------------------------------------------------------
    // FIN CORRECCIÓN
    // ----------------------------------------------------------------------

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

    public function cargarSesiones()
    {
        $this->sesiones = Sesion::where('paciente_id', $this->paciente->id)
            ->orderBy('id')
            ->get();

        $this->serieActiva = $this->sesiones->where('firma_paciente_digital', 0);
        $this->fecha_sesion = Carbon::today()->toDateString();

        $this->reset(['filtro']);
        Log::info("[LOAD] Sesiones cargadas. Activas: {$this->serieActiva->count()}");
    }

    public function confirmarGuardarSesion()
    {
        Log::info("[GUARDAR_CONFIRM] Iniciando confirmación de guardado. Sesion ID: {$this->sesionId}");

        try {
            $validatedData = $this->validate();

            if (is_null($this->sesionId)) {
                $activas = $this->serieActiva->count();
                $limite = $this->limiteSerie;

                if ($activas === $limite - 1) {
                    Log::info("[GUARDAR_CONFIRM] Límite inminente ({$activas}/{$limite}). Despachando alertaLimite.");
                    return $this->dispatch('alertaLimite', [
                        'title' => '¡Atención!',
                        'text' => "Estás a punto de registrar la sesión N°{$this->sesion_nro}, la última sesión de la serie ({$limite}/{$limite}). ¿Deseas continuar guardando?"
                    ]);
                }

                if ($activas >= $limite) {
                    Log::warning("[GUARDAR_CONFIRM] Límite alcanzado ({$activas}/{$limite}). Despachando alertaContinuar.");
                    return $this->dispatch('alertaContinuar', [
                        'title' => '¡Límite de Sesiones!',
                        'text' => "Ya tienes {$activas} sesiones activas (límite: {$limite}). ¿Quieres guardar esta sesión como extra o finalizar la serie ahora?"
                    ]);
                }
            }

            Log::info("[GUARDAR_CONFIRM] Datos validados correctamente. Despachando confirmación normal.");
            $this->dispatch('confirmarGuardado');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning("[GUARDAR_CONFIRM] Validación fallida: " . json_encode($e->errors()));
            throw $e;
        }
    }

    public function guardarSesion()
    {
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

        $this->resetCampos(); // Reinicia el formulario al próximo número y recarga la lista

        $this->dispatch('sesionGuardada', [
            'title' => '¡Éxito!',
            'text' => "Sesión {$action} correctamente.",
            'icon' => 'success'
        ]);
    }

    public function editarSesion($id)
    {
        Log::info("[EDICIÓN] Iniciando edición de Sesión ID: {$id}");
        $sesion = Sesion::findOrFail($id);

        $this->sesionId = $sesion->id;
        $this->sesion_nro = $sesion->sesion_nro; // Mantiene el N° Sesión para edición
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

    public function finalizarSerie()
    {
        Log::info("[FINALIZAR_CONFIRM] Iniciando confirmación para finalizar serie.");

        $activas = $this->serieActiva->count();

        if ($activas > 0) {
            $this->dispatch('confirmarFinalizarSerie');
        } else {
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
            // Marca todas las sesiones activas como inactivas
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

        $this->resetCampos(); // Esto llama a calcularProximaSesionNro() y lo resetea a 1.
    }

    public function resetCampos(): void
    {
        Log::debug("[RESET] Reseteando campos del formulario.");

        $this->sesionId = null;
        $this->tratamiento_fisiokinetico = null;
        $this->evolucion_sesion = null;
        $this->resetValidation();

        // 💡 Usa la nueva lógica que devuelve 1 si no hay sesiones activas.
        $this->sesion_nro = $this->calcularProximaSesionNro();

        $this->cargarSesiones();
    }

    public function render()
    {
        return view('livewire.kinesiologia.sesion-kinesiologica')
            ->layout('layouts.app');
    }
}
