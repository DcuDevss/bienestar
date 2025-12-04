<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
// 1. 🔑 Incluir el trait de paginación
use Livewire\WithPagination;
use App\Models\RegistroSesion as Sesion;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
// Usar el paginador predeterminado de Livewire para reiniciar la página
use Livewire\Attributes\On;

class SesionKinesiologica extends Component
{
    // 1. 🔑 Usar el trait de paginación
    use WithPagination;

    // Propiedades del paciente y del formulario
    public $paciente;
    public $sesionId;
    public $sesion_nro;
    public $fecha_sesion;
    public $tratamiento_fisiokinetico;
    public $evolucion_sesion;

    public $seleccionados = [];
    public $selectAll = false;


    // Propiedades de la UI y la data
    // No necesitamos $this->sesiones aquí, la consulta se hace en el getter paginado.
    // public $sesiones; // ⬅️ Eliminada o no usada directamente en la consulta principal
    public $serieActiva; // Se mantiene para el contador de alerta y la lógica de negocio
    public $nuevaSerie = false;
    public $filtro = 'todas';
    public $limiteSerie = 10; // Límite de sesiones para la alerta visual

    // Variables
    public $seleccionadosPorPagina = []; // array de arrays: ['pagina1' => [id1,id2], 'pagina2' => [...]]
    public $selectAllPorPagina = [];    // array de booleans: ['pagina1' => true/false]

    // 2. 🔑 Propiedades de Paginación
    public $perPage = 10;
    // Resetea la página cuando cambia el filtro (Livewire v3)
    #[On('setFilter')]
    public function setFilter(string $filtro)
    {
        $this->filtro = $filtro;
        $this->resetPage(); // Resetea la paginación al cambiar el filtro
    }

    // Listeners para eventos de SweetAlert2
    protected $listeners = [
        'finalizarSerieConfirmada' => 'finalizarSerieConfirmada',
        'guardarSesionConfirmada' => 'guardarSesion',
        'continuarGuardadoForzado' => 'guardarSesion',
        // NUEVO
        'eliminarSesionConfirmada' => 'eliminarSesion',
    ];

    // 🔥 CONEXIÓN CRUCIAL: Este Listener recibe el evento del JavaScript
    #[On('confirmarEliminacionMasiva')]
    public function eliminarSeleccionados()
    {
        Log::info('*** ELIMINACIÓN MASIVA CONFIRMADA POR USUARIO ***');

        if (empty($this->seleccionados)) {
            Log::warning('No hay IDs seleccionados para eliminar. Retornando.');
            return;
        }

        // Asegúrate de que los IDs sean enteros antes de la consulta
        $ids = array_map('intval', $this->seleccionados);

        // Ejecuta la eliminación en la base de datos
        Sesion::whereIn('id', $ids)->delete();

        // Limpia la selección en el componente
        $this->seleccionados = [];
        $this->selectAll = false;

        Log::info('Eliminación exitosa. Sesiones eliminadas: ' . implode(', ', $ids));

        // Modifica la línea del dispatch en public function eliminarSeleccionados()
        $this->dispatch(
            'swal',
            title: 'Sesiones eliminadas',
            text: 'Las sesiones seleccionadas fueron eliminadas correctamente.',
            icon: 'success'
        );
    }

    // Toggle selección de todos los de la página actual
    public function updatedSelectAll($value) // $value será true o false
    {
        Log::info('*** updatedSelectAll INICIADO ***');
        Log::info('Nuevo valor de $selectAll: ' . ($value ? 'true' : 'false'));

        // Asegúrate de mapear los IDs a string para evitar conflictos de tipo con wire:model
        // IMPORTANTE: Asegúrate que $this->sesionesFiltradas contenga los datos correctos.
        $currentItems = $this->sesionesFiltradas->pluck('id')->map(fn($id) => (string)$id);
        Log::info('IDs en la página actual ($sesionesFiltradas): ' . $currentItems->implode(', '));

        if ($value) {
            // Selecciona SOLO los IDs de la página actual
            $this->seleccionados = $currentItems->toArray();
        } else {
            // Deselecciona todo de la página actual
            $this->seleccionados = [];
        }

        Log::info('Resultado de $seleccionados después de updatedSelectAll: ' . implode(', ', $this->seleccionados));
        Log::info('*** updatedSelectAll FINALIZADO ***');
    }

    // NUEVA LÓGICA CRUCIAL: Sincroniza el checkbox "Seleccionar Todo"
    public function updatedSeleccionados()
    {
        Log::info('*** updatedSeleccionados INICIADO ***');
        Log::info('IDs seleccionados actualmente: ' . implode(', ', $this->seleccionados));

        // Compara el conteo de seleccionados con el total de ítems en la página actual
        $allItemsCount = $this->sesionesFiltradas->count();
        Log::info('Total de ítems en la página: ' . $allItemsCount);

        if (count($this->seleccionados) === $allItemsCount && $allItemsCount > 0) {
            $this->selectAll = true;
            Log::info('Resultado: $selectAll se establece en TRUE (todos seleccionados).');
        } else {
            $this->selectAll = false;
            Log::info('Resultado: $selectAll se establece en FALSE (selección incompleta).');
        }

        Log::info('*** updatedSeleccionados FINALIZADO ***');
    }

    // Reiniciar selección al cambiar de página
    public function updatedPage()
    {
        Log::info('*** updatedPage INICIADO ***');

        $this->seleccionados = [];
        $this->selectAll = false;

        Log::info('Página cambiada. Selección reseteada.');
    }


    //Hasta aca:

    // Se ejecuta cada vez que $perPage o $filtro cambia (para reiniciar la página)
    public function updatedPerPage()
    {
        $this->resetPage();
    }

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
        $this->cargarDatosSerieActiva(); // Carga la serie activa para el contador
        // 💡 Inicializa el formulario para la primera sesión
        $this->resetCampos();
    }

    /**
     * Carga solo las sesiones activas, usadas para el contador de límite (10/10).
     */
    public function cargarDatosSerieActiva()
    {
        // 💡 Solo se necesita esta consulta simple para obtener la cuenta
        $this->serieActiva = Sesion::where('paciente_id', $this->paciente->id)
            ->where('firma_paciente_digital', 0)
            ->get();
    }

    /**
     * Calcula el número de sesión consecutivo.
     */
    private function calcularProximaSesionNro(): int
    {
        // Cuenta las sesiones activas reales
        $cantidad = $this->serieActiva->count();

        // La próxima sesión es la cantidad + 1
        return $cantidad + 1;
    }


    /**
     * 3. 🔑 Propiedad Calculada para obtener la lista de sesiones PAGINADAS.
     * Reemplaza la lógica de la propiedad anterior (getSesionesFiltradasProperty)
     */
    public function getSesionesFiltradasProperty()
    {
        $query = Sesion::where('paciente_id', $this->paciente->id)
            ->orderBy('id', 'desc'); // Ordenar por ID para ver las más recientes primero

        if ($this->filtro === 'activas') {
            $query->where('firma_paciente_digital', 0);
        }

        if ($this->filtro === 'inactivas') {
            $query->where('firma_paciente_digital', 1);
        }

        // 🔑 Retorna el objeto Paginator, NO una Collection
        return $query->paginate($this->perPage);
    }

    // 💡 Método obsoleto: Ya no se usa para cargar la lista de sesiones, solo para el estado activo
    // public function cargarSesiones() { ... }
    // Ahora, simplemente llamamos a cargarDatosSerieActiva() para el contador.

    public function confirmarGuardarSesion()
    {
        Log::info("[GUARDAR_CONFIRM] Iniciando confirmación de guardado. Sesion ID: {$this->sesionId}");

        try {
            // Si es edición, salta la lógica de límite
            if (!is_null($this->sesionId)) {
                Log::info("[GUARDAR_CONFIRM] Es edición. Despachando confirmación normal.");
                return $this->dispatch('confirmarGuardado');
            }

            $validatedData = $this->validate();

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

        // ❗❗ CERRAR MODAL AL GUARDAR
        $this->dispatch('cerrar-modal');

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


        // ✅ LÍNEA CORREGIDA
        audit_log(
            'sesion.edit',  // <-- Argumento 1: Evento
            $sesion,        // <-- Argumento 2: Objeto (Modelo)
            "Se Edito el registro" // <-- Argumento 3: Descripción
        );


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

            // 💡 ACTUALIZAR LA SERIE ACTIVA ANTES DE RESETEAR
            $this->cargarDatosSerieActiva();
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

            // 🧾 AUDITORÍA: Finalización de la Serie de Sesiones
            audit_log(
                'sesion.finalizada',
                $this->paciente,
                "Se finalizó la serie de {$count} sesiones activas"
            );

            $this->dispatch('sesionGuardada', [
                'title' => '¡Serie Finalizada!',
                'text' => "Todas las sesiones activas han sido marcadas como inactivas.",
                'icon' => 'success'
            ]);
        }

        $this->resetCampos(); // Esto llama a calcularProximaSesionNro() y recarga la lista
        // ❗❗ CERRAR MODAL AL GUARDAR
        $this->dispatch('cerrar-modal');
    }

    public function resetCampos(): void
    {
        Log::debug("[RESET] Reseteando campos del formulario.");

        $this->sesionId = null;
        $this->tratamiento_fisiokinetico = null;
        $this->evolucion_sesion = null;
        $this->resetValidation();

        // 💡 Lógica de actualización de la cuenta de activas
        $this->cargarDatosSerieActiva();

        // 💡 Obtiene el próximo número de sesión
        $this->sesion_nro = $this->calcularProximaSesionNro();

        // 💡 Restablece la fecha a hoy
        $this->fecha_sesion = Carbon::today()->toDateString();
    }

    public function render()
    {
        return view('livewire.kinesiologia.sesion-kinesiologica', [
            // 🔑 Pasar las sesiones filtradas y paginadas a la vista
            'sesionesFiltradas' => $this->sesionesFiltradas,
        ])->layout('layouts.app');
    }
}
