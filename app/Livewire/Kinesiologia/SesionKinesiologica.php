<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use App\Models\RegistroSesion as Sesion;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Asegúrate de que este use esté activo

class SesionKinesiologica extends Component
{
    public $paciente;
    public $sesionId;
    public $sesion_nro;
    public $fecha_sesion;
    public $tratamiento_fisiokinetico;
    public $evolucion_sesion;

    public $sesiones;
    public $serieActiva;
    public $nuevaSerie = false;
    public $filtro = 'todas';
    public $limiteSerie = 10;

    protected $listeners = [
        'finalizarSerieConfirmada' => 'finalizarSerieConfirmada',
        'guardarSesionConfirmada' => 'guardarSesion',
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

    public function getSesionesFiltradasProperty()
    {
        // El log en el accessor puede ser muy ruidoso, se omite por defecto.
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

        // Lógica de autoincremento...
        if ($this->serieActiva->count() > 0) {
            $this->sesion_nro = $this->serieActiva->last()->sesion_nro + 1;
        } else {
            $this->sesion_nro = 1;
        }

        $this->fecha_sesion = Carbon::today()->toDateString();
        $this->reset(['filtro']);
        Log::info("[LOAD] Sesiones cargadas. Activas: {$this->serieActiva->count()}");
    }

    /* -------------------------------------------------
     * FLUJO DE GUARDADO CON CONFIRMACIÓN (SweetAlert2)
     ------------------------------------------------- */
    public function confirmarGuardarSesion()
    {
        Log::info("[GUARDAR_CONFIRM] Iniciando confirmación de guardado. Sesion ID: {$this->sesionId}");

        try {
            // 1. Validar datos
            $this->validate();
            Log::info("[GUARDAR_CONFIRM] Datos validados correctamente.");

            // 2. Disparar SweetAlert de confirmación
            $this->dispatch('confirmarGuardado');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning("[GUARDAR_CONFIRM] Validación fallida: " . json_encode($e->errors()));
            throw $e; // Relanzar la excepción para que Livewire maneje los errores
        }
    }

    // Este método solo se ejecuta si el usuario confirma en SweetAlert
    public function guardarSesion()
    {
        Log::info("[GUARDAR_FINAL] Confirmación recibida. Ejecutando guardado final.");

        $isUpdate = !is_null($this->sesionId);
        $action = $isUpdate ? 'actualizada' : 'registrada';

        Sesion::updateOrCreate(
            ['id' => $this->sesionId],
            [
                'paciente_id' => $this->paciente->id,
                'sesion_nro' => $this->sesion_nro,
                'fecha_sesion' => $this->fecha_sesion,
                'tratamiento_fisiokinetico' => $this->tratamiento_fisiokinetico,
                'evolucion_sesion' => $this->evolucion_sesion,
                'firma_paciente_digital' => 0
            ]
        );

        Log::info("[GUARDAR_FINAL] Sesión {$action} con ID: {$this->sesionId}");

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
        $this->fecha_sesion = $sesion->fecha_sesion instanceof Carbon ? $sesion->fecha_sesion->format('Y-m-d') : $sesion->fecha_sesion;
        $this->tratamiento_fisiokinetico = $sesion->tratamiento_fisiokinetico;
        $this->evolucion_sesion = $sesion->evolucion_sesion;

        $this->dispatch('abrirFormulario');
        Log::info("[EDICIÓN] Campos cargados. Despachando abrirFormulario.");
    }

    public function eliminarSesion($id)
    {
        Log::warning("[ELIMINACIÓN] Eliminando Sesión ID: {$id}");
        Sesion::findOrFail($id)->delete();

        $this->cargarSesiones();
        session()->flash('mensaje', 'Sesión eliminada.');
        Log::warning("[ELIMINACIÓN] Sesión eliminada exitosamente.");
    }

    /* -------------------------------------------------
     * FINALIZAR SERIE – con confirmación SweetAlert2
     ------------------------------------------------- */
    public function finalizarSerie()
    {
        Log::info("[FINALIZAR_CONFIRM] Iniciando confirmación para finalizar serie.");
        $this->dispatch('confirmarFinalizarSerie');
    }

    public function finalizarSerieConfirmada()
    {
        Log::info("[FINALIZAR_FINAL] Confirmación recibida. Ejecutando finalización de serie.");
        $count = $this->serieActiva->count();

        Sesion::where('paciente_id', $this->paciente->id)
            ->where('firma_paciente_digital', 0)
            ->update(['firma_paciente_digital' => 1]);

        $this->resetCampos();
        $this->cargarSesiones();

        Log::info("[FINALIZAR_FINAL] {$count} sesiones marcadas como inactivas.");

        $this->dispatch('sesionGuardada', [
            'title' => '¡Serie Finalizada!',
            'text' => "Todas las sesiones activas han sido marcadas como inactivas.",
            'icon' => 'success'
        ]);
    }

    private function resetCampos()
    {
        Log::debug("[RESET] Reseteando campos del formulario.");
        $this->sesionId = null;
        $this->tratamiento_fisiokinetico = '';
        $this->evolucion_sesion = '';
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.kinesiologia.sesion-kinesiologica')
            ->layout('layouts.app');
    }
}
