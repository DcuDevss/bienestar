<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Disase;
use App\Models\Enfermedade;
use App\Models\Paciente;
use Illuminate\Support\Str;
use App\Models\Tipolicencia;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class PatientHistorialEnfermedades extends Component
{
    use WithPagination;
    use WithFileUploads;

    #[Url]
    public $search = '';
    public $perPage = 4;

    public $sortAsc = true;
    public $sortField = 'name';

    public $enfermedadeId;
    public $name, $fecha_enfermedad, $tipo_enfermedad, $fecha_finalizacion, $fecha_atencion, $activo, $tipolicencia_id,
        $enfermedade_id, $paciente_enfermedades, $patient, $enfermedade, $archivo, $art;

    public $modal = false;

    public $detalle_diagnostico, $fecha_atencion_enfermedad, $fecha_finalizacion_enfermedad, $horas_reposo, $pdf_enfermedad,
        $imgen_enfermedad, $medicacion, $dosis, $detalle_medicacion, $nro_osef, $tipodelicencia, $pacienteId, $patient_disases;

    // --- Autocomplete dentro del modal ---
    public $nameSearch = '';          // lo que escribe en "Nombre" dentro del modal
    public $namePickerOpen = false;   // visibilidad del dropdown
    public $nameOptions = [];         // resultados (id, name, codigo)
    public $nameIndex = 0;            // navegación con teclado

    // Para mover pivot si cambian de enfermedad en el modal
    public $pivotId = null;
    public $original_enfermedade_id = null;

    protected $rules = [
        'name' => 'nullable',
        'detalle_diagnostico' => 'nullable',
        'fecha_atencion_enfermedad' => 'nullable',
        'fecha_finalizacion_enfermedad' => 'nullable',
        'horas_reposo' => 'nullable',
        'pdf_enfermedad' => 'nullable|file|mimes:pdf,png,jpg,jpeg,gif|max:10240',
        'imgen_enfermedad' => 'nullable|file',
        'medicacion' => 'nullable',
        'dosis' => 'nullable',
        //'estado_enfermedad'=>'nullable',
        'detalle_medicacion' => 'nullable',
        'nro_osef' => 'nullable',
        'art' => 'nullable',
        'tipodelicencia' => 'nullable',
        'enfermedade_id' => 'required',
    ];

    public function mount($paciente)
    {
        $this->pacienteId = $paciente;
    }

    /** Abre el modal con los datos de la enfermedad (y prepara el autocomplete) */
    public function editModalDisase($enfermedadeId)
    {
        $paciente = Paciente::with(['enfermedades' => function ($query) use ($enfermedadeId) {
            $query->where('enfermedades.id', $enfermedadeId);
        }])->find($this->pacienteId);

        if ($paciente && $paciente->enfermedades->isNotEmpty()) {
            $enf = $paciente->enfermedades->first();

            // Datos base
            $this->name  = $enf->name;
            $this->enfermedade_id = $enf->id;

            // Guardamos info para poder mover la relación si cambian de enfermedad
            $this->original_enfermedade_id = $enf->id;
            $this->pivotId = $enf->pivot->id ?? null;

            // Campos del pivot
            $this->fecha_atencion_enfermedad     = $enf->pivot->fecha_atencion_enfermedad ?? null;
            $this->detalle_medicacion            = $enf->pivot->detalle_medicacion ?? null;
            $this->fecha_finalizacion_enfermedad = $enf->pivot->fecha_finalizacion_enfermedad ?? null;
            $this->horas_reposo                  = $enf->pivot->horas_reposo ?? null;
            $this->medicacion                    = $enf->pivot->medicacion ?? null;
            $this->dosis                         = $enf->pivot->dosis ?? null;
            $this->nro_osef                      = $enf->pivot->nro_osef ?? null;
            $this->art                           = $enf->pivot->art ?? null;
            $this->detalle_diagnostico           = $enf->pivot->detalle_diagnostico ?? null;
            $this->tipodelicencia                = $enf->pivot->tipodelicencia ?? null;

            $this->modal = true;

// Inicializa el autocomplete SIN pisar la escritura del usuario
$this->nameSearch = '';           // <- importante para que empiece limpio
$this->namePickerOpen = false;
$this->nameOptions = [];

            // Inicializa el autocomplete con el nombre actual
            $this->openNamePicker();
        }
    }

    /** Guardar cambios del modal */
    public function editDisase()
    {
        $data = $this->validate();

        $paciente = Paciente::find($this->pacienteId);
        if (!$paciente) return;

        // Directorio para archivos
        $directoryPath = "public/archivos_enfermedades/paciente_{$paciente->id}";

        // Imagen
        if (isset($data['imgen_enfermedad'])) {
            $archivoPath = $data['imgen_enfermedad']->storeAs($directoryPath, $data['imgen_enfermedad']->getClientOriginalName());
            if (!str_starts_with($data['imgen_enfermedad']->getMimeType(), 'image/')) {
                $this->addError('imgen_enfermedad', 'El imgen_enfermedad debe ser una imagen.');
                return;
            }
        } else {
            // mantener actual
            $enfActual = $paciente->enfermedades()->findOrFail($this->original_enfermedade_id);
            $archivoPath = $enfActual->pivot->imgen_enfermedad;
        }

        // PDF
        if (isset($data['pdf_enfermedad'])) {
            if ($data['pdf_enfermedad']->getMimeType() !== 'application/pdf') {
                $this->addError('pdf_enfermedad', 'El pdf_enfermedad debe ser un archivo PDF.');
                return;
            }
            $archivoPathDorso = $data['pdf_enfermedad']->storeAs($directoryPath, $data['pdf_enfermedad']->getClientOriginalName());
        } else {
            $enfActual = $enfActual ?? $paciente->enfermedades()->findOrFail($this->original_enfermedade_id);
            $archivoPathDorso = $enfActual->pivot->pdf_enfermedad;
        }

        // Datos del pivot a persistir (se usan tanto si cambia como si no cambia la enfermedad)
        $pivotData = [
            'fecha_atencion_enfermedad'     => $data['fecha_atencion_enfermedad'],
            'detalle_medicacion'            => $data['detalle_medicacion'],
            'detalle_diagnostico'           => $data['detalle_diagnostico'],
            'imgen_enfermedad'              => $archivoPath,
            'pdf_enfermedad'                => $archivoPathDorso,
            'fecha_finalizacion_enfermedad' => $data['fecha_finalizacion_enfermedad'],
            'horas_reposo'                  => $data['horas_reposo'],
            'nro_osef'                      => $data['nro_osef'],
            'art'                           => $data['art'],
            'medicacion'                    => $data['medicacion'],
            'dosis'                         => $data['dosis'],
            'tipodelicencia'                => $data['tipodelicencia'],
        ];

        $changedDisease = ($this->enfermedade_id != $this->original_enfermedade_id);

        if ($changedDisease) {
            // Si cambiaron a otra enfermedad, movemos la relación de pivot:
            // 1) quitamos la relación vieja
            $paciente->enfermedades()->detach($this->original_enfermedade_id);
            // 2) adjuntamos la nueva con los mismos campos
            $paciente->enfermedades()->attach($this->enfermedade_id, $pivotData);
            // NOTA: no cambiamos el nombre/slug del modelo de enfermedad cuando se cambia a otra
        } else {
            // Misma enfermedad: actualizamos modelo y pivot
            $enfermedade = $paciente->enfermedades()->findOrFail($this->enfermedade_id);

            // Mantengo tu comportamiento original: actualizar nombre/slug del modelo seleccionado
            $enfermedade->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
            ]);

            // Actualizar pivot en la misma relación
            $paciente->enfermedades()->updateExistingPivot($this->enfermedade_id, $pivotData);
        }

        // Cerrar modal y limpiar
        $this->modal = false;
        $this->dispatch('toast', type: 'success', message: 'Enfermedad editada correctamente');

        $this->reset([
            'name',
            'fecha_atencion_enfermedad',
            'detalle_diagnostico',
            'detalle_medicacion',
            'fecha_finalizacion_enfermedad',
            'horas_reposo',
            'medicacion',
            'nro_osef',
            'tipolicencia_id',
            'tipodelicencia',
            'art',
            'dosis',
            'imgen_enfermedad',
            'pdf_enfermedad',
            'search',
            // Autocomplete modal
            'nameSearch','namePickerOpen','nameOptions','nameIndex',
            'pivotId','original_enfermedade_id',
        ]);

        // Recargar lista
        $this->patient_disases = $paciente->enfermedades()->get();
        $this->resetValidation();
        $this->render();
    }

    // ====== Autocomplete del campo "Nombre" dentro del modal ======

 public function openNamePicker()
{
    // solo precarga si está vacío; NO pisar lo que el usuario ya escribió
    if ($this->nameSearch === '' && !empty($this->name)) {
        $this->nameSearch = $this->name;
    }
    $this->namePickerOpen = true;
    $this->updatedNameSearch($this->nameSearch);
}


    public function closeNamePicker()
    {
        $this->namePickerOpen = false;
    }

public function updatedNameSearch($value)
{
    $this->enfermedade_id = null; // hasta que elijan una opción
    $q = trim((string)$value);

    if ($q === '') {
        $this->nameOptions = [];
        $this->namePickerOpen = false;
        $this->nameIndex = 0;
        return;
    }

    // Usa el MISMO motor que el buscador de arriba (Scout).
    // Si no usás Scout, avisá y te lo cambio a "where like".
    $this->nameOptions = \App\Models\Enfermedade::search($q)
        ->take(10)
        ->get()
        ->map(fn($e) => [
            'id'     => $e->id,
            'name'   => $e->name,
            'codigo' => $e->codigo ?? null,
        ])->toArray();

    $this->namePickerOpen = !empty($this->nameOptions);
    $this->nameIndex = 0;
}



    public function updatedName($value)
    {
        // mientras escribe, anulamos el id hasta que elija algo
        $this->enfermedade_id = null;

        // reutilizamos la lógica de búsqueda del picker
        $this->nameSearch = $value;
        $this->updatedNameSearch($value); // <- ya arma $nameOptions y $namePickerOpen
    }

    public function pickEnfermedad($id)
    {
        if ($e = Enfermedade::find($id)) {
            $this->enfermedade_id = $e->id;
            $this->name = $e->name;           // para mostrar
            $this->nameSearch = $e->name;     // refleja la selección en el input
            $this->namePickerOpen = false;
        }
    }

    public function moveNameDown()
    {
        if (!$this->namePickerOpen) return;
        $this->nameIndex = min($this->nameIndex + 1, max(count($this->nameOptions) - 1, 0));
    }

    public function moveNameUp()
    {
        if (!$this->namePickerOpen) return;
        $this->nameIndex = max($this->nameIndex - 1, 0);
    }

    public function chooseNameHighlighted()
    {
        if ($this->namePickerOpen && isset($this->nameOptions[$this->nameIndex])) {
            $this->pickEnfermedad($this->nameOptions[$this->nameIndex]['id']);
        }
    }

    // =============================================================

    public function render()
    {
        $paciente = Paciente::find($this->pacienteId);

        if ($paciente) {
            $enfermedades = $paciente->enfermedades()
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('codigo', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.detalle_diagnostico', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.detalle_medicacion', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.fecha_finalizacion_enfermedad', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.horas_reposo', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.fecha_atencion_enfermedad', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.medicacion', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.nro_osef', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.art', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.tipodelicencia', 'like', '%' . $this->search . '%');
                })
                ->orderBy('enfermedade_paciente.id', $this->sortAsc ? 'desc' : 'asc')
                ->paginate($this->perPage, ['*'], 'enfermedades_page');

            return view('livewire.patient.patient-historial-enfermedades', [
                'paciente'     => $paciente,
                'enfermedades' => $enfermedades,
            ])->layout('layouts.app');
        }

        return view('livewire.patient.patient-historial-enfermedades')->layout('layouts.app');
    }
}
