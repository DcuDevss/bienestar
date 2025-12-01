<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Paciente;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\PacienteDisase;


use Carbon\Carbon;

class PatientHistorialCertificado extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $fecha_presentacion_certificado, $detalle_certificado, $fecha_finalizacion_licencia, $fecha_inicio_licencia,
        $horas_salud, $suma_salud, $estado_certificado, $tipolicencia_id, $imagen_frente, $imagen_dorso, $tipodelicencia,
        $disase_id, $patient_disases, $patient, $disase, $suma_auxiliar;



    public $fecha_enfermedad, $tipo_enfermedad, $fecha_finalizacion, $fecha_atencion, $activo,
        $paciente_id, $disases, $archivo;

    public $selectedDisase;
    public $modal = false;
    public $modalEdit = false;

    public $editedDisaseName;       // campo que editás en el modal
    public $pacienteId;
    public $certificado_id;
    public $paciente;


    public $sortAsc = true;
    #[Url(history: true)] public $search = '';
    #[Url(history: true)] public $admin = '';
    #[Url(history: true)] public $sortBy = 'created_at';
    #[Url(history: true)] public $sortDir = 'DESC';
    #[Url()]            public $perPage = 4;

    // --- Autocomplete dentro del modal ---
    public $editPickerOpen = false;
    public $editOptions = [];
    public $editIndex = 0;
    public $original_disase_id = null; // para detectar cambio y mover el pivot

    protected $rules = [
        'name'                           => 'required',
        'fecha_presentacion_certificado' => 'required',
        'detalle_certificado'            => 'nullable',
        'fecha_inicio_licencia'          => 'required',
        'fecha_finalizacion_licencia'    => 'required|date|after_or_equal:fecha_inicio_licencia',
        'horas_salud'                    => 'nullable|integer',
        'suma_salud'                     => 'nullable|integer',
        // 🔑 CLAVE: Reglas de validación de archivos (max:1024 = 1MB)
        'imagen_frente'                => 'nullable|file|image|max:2560', // <-- CAMBIO AQUÍ
        'imagen_dorso'                 => 'nullable|file|image|max:2560', // <-- CAMBIO AQUÍ
        'estado_certificado'             => 'nullable|boolean',
        'tipolicencia_id'                => 'nullable',
        'disase_id'                      => 'required', // debe elegir una opción
        'suma_auxiliar'                  => 'nullable|integer',
    ];

    // 🔑 CLAVE: Añade la propiedad $messages aquí.
    protected $messages = [
        'imagen_frente.max' => 'El tamaño del archivo Frente Certificado no debe exceder 2.5 MB.',
        'imagen_dorso.max'  => 'El tamaño del archivo Dorso Certificado no debe exceder 2.5 MB.',
        'imagen_frente.image' => 'El archivo Frente debe ser una imagen válida (JPG, PNG, etc.).',
        'imagen_dorso.image'  => 'El archivo Dorso debe ser una imagen válida (JPG, PNG, etc.).',
    ];

    public function mount($paciente)
    {
        $this->pacienteId = $paciente;
    }

    /** Abre el modal con datos y prepara autocomplete */
    /* public function editModalDisase($disaseId)
    {
        Log::info('Entrando a editModalDisase', ['disaseId' => $disaseId, 'pacienteId' => $this->pacienteId]);

        $paciente = \App\Models\Paciente::with(['disases' => function ($q) use ($disaseId) {
            $q->where('disases.id', $disaseId);
        }])->find($this->pacienteId);

        if ($paciente) {
            Log::info('Paciente encontrado', ['pacienteId' => $paciente->id, 'disases_count' => $paciente->disases->count()]);
        } else {
            Log::warning('Paciente no encontrado', ['pacienteId' => $this->pacienteId]);
        }

        if ($paciente && $paciente->disases->isNotEmpty()) {
            $d = $paciente->disases->first();

            Log::info('Disase encontrado', ['disaseId' => $d->id, 'name' => $d->name, 'pivot' => $d->pivot]);

            $this->name                          = $d->name;
            $this->editedDisaseName              = $d->name;
            $this->disase_id                     = $d->id;
            $this->original_disase_id            = $d->id;

            $this->fecha_presentacion_certificado = $d->pivot->fecha_presentacion_certificado ?? null;
            $this->fecha_inicio_licencia          = $d->pivot->fecha_inicio_licencia ?? null;
            $this->fecha_finalizacion_licencia    = $d->pivot->fecha_finalizacion_licencia ?? null;
            $this->horas_salud                    = $d->pivot->horas_salud ?? null;
            $this->suma_salud                     = $d->pivot->suma_salud ?? null;
            $this->suma_auxiliar                  = $d->pivot->suma_auxiliar ?? null;
            $this->estado_certificado             = $d->pivot->estado_certificado ?? null;
            $this->detalle_certificado            = $d->pivot->detalle_certificado ?? null;
            $this->tipolicencia_id                = $d->pivot->tipolicencia_id ?? null;

            $this->modal = true;
            $this->editPickerOpen = false; // no abrir automáticamente

            Log::info('Variables seteadas para modal', [
                'name' => $this->name,
                'editedDisaseName' => $this->editedDisaseName,
                'disase_id' => $this->disase_id,
                'fecha_presentacion_certificado' => $this->fecha_presentacion_certificado,
            ]);
        } else {
            Log::warning('No se encontraron disases para el paciente con ese disaseId', [
                'pacienteId' => $this->pacienteId,
                'disaseId' => $disaseId
            ]);
        }
    } */
    public $old_imagen_frente, $old_imagen_dorso;
    /*Nuevo Modal */
    /*   public function editModalDisase($disaseId, $certificadoId)
    {
        Log::info('Entrando a editModalDisase', [
            'disaseId' => $disaseId,
            'certificadoId' => $certificadoId,
            'pacienteId' => $this->pacienteId,
        ]);

        $this->disase_id = $disaseId;
        $this->certificado_id = $certificadoId;

        // Buscar pivot directamente
        $pivot = DB::table('disase_paciente')
            ->where('id', $certificadoId)
            ->first();

        if (!$pivot) {
            Log::warning('No se encontró certificado pivot', ['certificadoId' => $certificadoId]);
            return;
        }

        $disase = \App\Models\Disase::find($pivot->disase_id);

        if (!$disase) {
            Log::warning('No se encontró disase', ['disase_id' => $pivot->disase_id]);
            return;
        }

        $this->name = $disase->name;
        $this->editedDisaseName = $disase->name;
        $this->tipolicencia_id = $pivot->tipolicencia_id;
        $this->fecha_presentacion_certificado = $pivot->fecha_presentacion_certificado;
        $this->fecha_inicio_licencia = $pivot->fecha_inicio_licencia;
        $this->fecha_finalizacion_licencia = $pivot->fecha_finalizacion_licencia;
        $this->horas_salud = $pivot->horas_salud;
        $this->suma_salud = $pivot->suma_auxiliar;
        $this->detalle_certificado = $pivot->detalle_certificado;
        // ASIGNA las rutas antiguas a las nuevas propiedades de respaldo (old_)
        $this->old_imagen_frente = $pivot->imagen_frente; //
        $this->old_imagen_dorso = $pivot->imagen_dorso;   //

        $this->modal = true;
        $this->editPickerOpen = false;

        Log::info('Variables seteadas para modal', [
            'name' => $this->name,
            'editedDisaseName' => $this->editedDisaseName,
            'disase_id' => $this->disase_id,
            'certificado_id' => $this->certificado_id,
        ]);
    } */

    //NUEVO METODO PARA AGREGAR Y GUARDAR enfermedades
    public function editModalDisase($disaseId, $certificadoId)
    {
        Log::info('Entrando a editModalDisase', [
            'disaseId' => $disaseId,
            'certificadoId' => $certificadoId,
            'pacienteId' => $this->pacienteId,
        ]);

        $this->disase_id = $disaseId;
        $this->certificado_id = $certificadoId;
        // 🔑 CLAVE: Almacenar el ID original.
        $this->original_disase_id = $disaseId; // <-- ¡Añadida la línea aquí!

        // Buscar pivot directamente
        $pivot = DB::table('disase_paciente')
            ->where('id', $certificadoId)
            ->first();

        if (!$pivot) {
            Log::warning('No se encontró certificado pivot', ['certificadoId' => $certificadoId]);
            return;
        }

        $disase = \App\Models\Disase::find($pivot->disase_id);

        if (!$disase) {
            Log::warning('No se encontró disase', ['disase_id' => $pivot->disase_id]);
            return;
        }

        $this->name = $disase->name;
        $this->editedDisaseName = $disase->name;
        $this->tipolicencia_id = $pivot->tipolicencia_id;
        $this->fecha_presentacion_certificado = $pivot->fecha_presentacion_certificado;
        $this->fecha_inicio_licencia = $pivot->fecha_inicio_licencia;
        $this->fecha_finalizacion_licencia = $pivot->fecha_finalizacion_licencia;
        $this->horas_salud = $pivot->horas_salud;
        $this->suma_salud = $pivot->suma_auxiliar;
        $this->detalle_certificado = $pivot->detalle_certificado;
        // ASIGNA las rutas antiguas a las nuevas propiedades de respaldo (old_)
        $this->old_imagen_frente = $pivot->imagen_frente; //
        $this->old_imagen_dorso = $pivot->imagen_dorso;  //

        $this->modal = true;
        $this->editPickerOpen = false;

        Log::info('Variables seteadas para modal', [
            'name' => $this->name,
            'editedDisaseName' => $this->editedDisaseName,
            'disase_id' => $this->disase_id,
            'original_disase_id' => $this->original_disase_id, // Añadido para el log
            'certificado_id' => $this->certificado_id,
        ]);
    }

    /** Buscar sugerencias al tipear en el input del modal */


    public function updatedEditedDisaseName($value)
    {
        Log::info('updatedEditedDisaseName called', ['value' => $value]);

        $this->disase_id = null; // obliga a elegir una
        $q = trim((string)$value);

        Log::info('Trimmed search query', ['query' => $q]);

        if ($q === '') {
            Log::info('Query is empty, resetting edit options');
            $this->editOptions = [];
            $this->editPickerOpen = false;
            $this->editIndex = 0;
            return;
        }

        $this->editOptions = \App\Models\Disase::query()
            ->where('name', 'like', "%{$q}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name'])
            ->toArray();

        Log::info('Search results', ['count' => count($this->editOptions), 'options' => $this->editOptions]);

        $this->editPickerOpen = true; // Forzar apertura si hay texto
        /* $this->editPickerOpen = !empty($this->editOptions); */
        $this->editIndex = 0;
    }

    public function openEditPicker()
    {
        $this->editPickerOpen = true;
    }
    public function closeEditPicker()
    {
        $this->editPickerOpen = false;
    }

    /** Seleccionar una sugerencia */
    public function pickEditedDisase($id)
    {
        if ($d = \App\Models\Disase::find($id)) {
            $this->disase_id        = $d->id;
            $this->editedDisaseName = $d->name;
            $this->editPickerOpen   = false;
        }
    }



    public function addNewEditedDisase()
    {
        $newDisaseName = trim($this->editedDisaseName);

        if (empty($newDisaseName) || strlen($newDisaseName) < 3) {
            $this->dispatch('swal', title: 'Error', text: 'El nombre debe ser más largo para crearlo.', icon: 'warning');
            return;
        }

        // 1. Crear el nuevo registro
        $newDisase = \App\Models\Disase::firstOrCreate(
            ['name' => mb_strtolower($newDisaseName)],
            ['slug' => Str::slug($newDisaseName), 'symptoms' => '']
        );

        // 2. Seleccionar el nuevo padecimiento
        $this->pickEditedDisase($newDisase->id);

        // 3. Opcional: Notificación de éxito
        $this->dispatch('swal', title: 'Agregado', text: 'Padecimiento "' . $newDisaseName . '" creado y seleccionado.', icon: 'success');
    }



    /** Guardar cambios */


    public function editDisase()
    {
        Log::info('Inicio de editDisase', [
            'pacienteId' => $this->pacienteId,
            'original_disase_id' => $this->original_disase_id,
            'disase_id' => $this->disase_id,
            'editedDisaseName' => $this->editedDisaseName,
            'certificado_id' => $this->certificado_id ?? null,
        ]);

        $data = $this->validate();

        $paciente = \App\Models\Paciente::find($this->pacienteId);
        if (!$paciente) {
            Log::error('Paciente no encontrado al guardar editDisase', ['pacienteId' => $this->pacienteId]);
            return;
        }
        /* $disase   = $paciente->disases()->find($this->original_disase_id); */
        // Intento obtener el disase relacionado (solo para leer el pivot si hace falta)
        $disase = $this->original_disase_id ? $paciente->disases()->find($this->original_disase_id) : null;

        if (!$disase && !$this->certificado_id) {
            Log::error('Disase no encontrado en paciente y sin certificado_id', [
                'paciente_id' => $this->pacienteId,
                'original_disase_id' => $this->original_disase_id,
                'certificado_id' => $this->certificado_id ?? null,
            ]);
            return;
        }

        $dir = "public/archivos_disases/paciente_{$paciente->id}";

        // imagen frente
        if (isset($data['imagen_frente'])) {
            // ... (Tu lógica de guardado de archivo nuevo) ...
            $archivoPath = $data['imagen_frente']->storeAs($dir, $data['imagen_frente']->getClientOriginalName());
            $this->optimizarImagen(storage_path('app/' . $archivoPath));
        } else {
            // Usa la ruta antigua guardada si no se subió un archivo nuevo.
            $archivoPath = $this->old_imagen_frente; // <--- CAMBIO CLAVE
        }

        // imagen dorso
        if (isset($data['imagen_dorso'])) {
            // ... (Tu lógica de guardado de archivo nuevo) ...
            $archivoPathDorso = $data['imagen_dorso']->storeAs($dir, $data['imagen_dorso']->getClientOriginalName());
            $this->optimizarImagen(storage_path('app/' . $archivoPathDorso));
        } else {
            // Usa la ruta antigua guardada si no se subió un archivo nuevo.
            $archivoPathDorso = $this->old_imagen_dorso; // <--- CAMBIO CLAVE
        }

        $suma_auxiliar = null;
        if (!empty($data['fecha_inicio_licencia']) && !empty($data['fecha_finalizacion_licencia'])) {
            $suma_auxiliar = Carbon::parse($data['fecha_inicio_licencia'])
                ->diffInDays(Carbon::parse($data['fecha_finalizacion_licencia'])) + 1;
        }

        $pivotData = [
            'fecha_presentacion_certificado' => $data['fecha_presentacion_certificado'],
            'fecha_inicio_licencia'          => $data['fecha_inicio_licencia'],
            'detalle_certificado'            => $data['detalle_certificado'],
            'imagen_frente'                  => $archivoPath,
            'imagen_dorso'                   => $archivoPathDorso,
            'fecha_finalizacion_licencia'   => $data['fecha_finalizacion_licencia'],
            'horas_salud'                   => $data['horas_salud'],
            'suma_salud'                    => $suma_auxiliar,
            'disase_id'                      => $this->disase_id,
            'suma_auxiliar'                 => $suma_auxiliar,
            'estado_certificado'            => $data['estado_certificado'] ?? true,
            'tipolicencia_id'               => $data['tipolicencia_id'],
        ];

        Log::info('Datos para actualizar pivot', ['pivotData' => $pivotData]);

        $changed = ($this->disase_id != $this->original_disase_id);
        Log::info('¿Cambio de disase?', ['changed' => $changed]);

        try {
            if ($changed) {
                // Cambió el padecimiento → movemos el registro pivot al nuevo disase
                Log::info('Moviendo pivot a nuevo disase', [
                    'original_disase_id' => $this->original_disase_id,
                    'new_disase_id' => $this->disase_id,
                    'certificado_id' => $this->certificado_id ?? null,
                ]);

                if (!empty($this->certificado_id)) {
                    DB::table('disase_paciente')
                        ->where('id', $this->certificado_id)
                        ->update($pivotData);
                } else {
                    $paciente->disases()->updateExistingPivot($this->disase_id, $pivotData);
                }
            } else {
                // Mismo padecimiento → actualizar solo el pivot, SIN tocar la tabla disases
                Log::info('Actualizando pivot existente', ['disase_id' => $this->disase_id, 'certificado_id' => $this->certificado_id ?? null]);

                if (!empty($this->certificado_id)) {
                    // Actualizo la fila pivot específica
                    DB::table('disase_paciente')
                        ->where('id', $this->certificado_id)
                        ->update($pivotData);
                } else {
                    // Comportamiento por defecto (updateExistingPivot)
                    $paciente->disases()->updateExistingPivot($this->disase_id, $pivotData);
                }
            }

            // 🧾 AUDITORÍA
            audit_log('certificado.update', $paciente, 'Certificado del paciente actualizado');
        } catch (\Exception $e) {
            Log::error('Error actualizando pivot en editDisase', ['error' => $e->getMessage()]);
            $this->addError('general', 'Error al actualizar el certificado. Revisá logs.');
            return;
        }

        // cerrar modal / limpiar
        $this->modal = false;
        $this->dispatch('toast', type: 'success', message: 'Padecimiento actualizado correctamente');

        $this->dispatch(
            'swal',
            title: 'Actualizado',
            text: 'El certificado fue actualizado correctamente.',
            icon: 'success'
        );



        $this->reset([
            'name',
            'editedDisaseName',
            'fecha_presentacion_certificado',
            'detalle_certificado',
            'fecha_inicio_licencia',
            'fecha_finalizacion_licencia',
            'horas_salud',
            'suma_salud',
            'suma_auxiliar',
            'tipolicencia_id',
            'estado_certificado',
            'imagen_frente',
            'imagen_dorso',
            'search',
            'editPickerOpen',
            'editOptions',
            'editIndex',
            'original_disase_id',
            // no resetear certificado_id aquí si querés depurarlo, sino descomentá:
            //'certificado_id'
        ]);

        $this->patient_disases = $paciente->disases()->get();
        $this->resetValidation();

        Log::info('Finalización de editDisase');
        $this->render();
    }

    //  * Optimiza la imagen reduciendo su peso (sobrescribe el archivo)
    private function optimizarImagen($path)
    {
        if (!file_exists($path)) return;

        $info = pathinfo($path);
        $extension = strtolower($info['extension']);

        switch ($extension) {
            case 'png':
                $image = imagecreatefrompng($path);
                imagejpeg($image, $path, 60); // la convierte a JPG con calidad 60
                imagedestroy($image);
                break;
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($path);
                imagejpeg($image, $path, 60);
                imagedestroy($image);
                break;
            case 'webp':
                $image = imagecreatefromwebp($path);
                imagejpeg($image, $path, 60);
                imagedestroy($image);
                break;
            default:
                // otros formatos no se optimizaann
                break;
        }
    }

    /*  separador > */

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function delete(Paciente $paciente)
    {
        $paciente->delete();
    }
    public function setSortBy($f)
    {
        if ($this->sortBy === $f) {
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }
        $this->sortBy = $f;
        $this->sortDir = 'DESC';
    }

    public function render()
    {
        $paciente = Paciente::find($this->pacienteId);
        $tipolicencias = \App\Models\Tipolicencia::all()->keyBy('id');

        if ($paciente) {
            $enfermedades = $paciente->disases()
                ->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.detalle_certificado', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.fecha_inicio_licencia', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.fecha_finalizacion_licencia', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.horas_salud', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.fecha_presentacion_certificado', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.estado_certificado', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.suma_auxiliar', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.tipolicencia_id', 'like', '%' . $this->search . '%');
                })
                ->orderBy('disase_paciente.id', $this->sortAsc ? 'desc' : 'asc')
                ->paginate($this->perPage, ['*'], 'enfermedades_page');

            return view('livewire.patient.patient-historial-certificado', [
                'paciente' => $paciente,
                'enfermedades' => $enfermedades,
                'tipolicencias' => $tipolicencias,
            ])->layout('layouts.app');
        }

        return view('livewire.patient.patient-historial-certificado')->layout('layouts.app');
    }
}
