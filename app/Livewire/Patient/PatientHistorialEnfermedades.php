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

    public $sortAsc = true;   //public $sortAsc = true;
    public $sortField = 'name';



    public $enfermedadeId;
    public $name, $fecha_enfermedad, $tipo_enfermedad, $fecha_finalizacion, $fecha_atencion, $activo, $tipolicencia_id,
        $enfermedade_id, $paciente_enfermedades, $patient, $enfermedade, $archivo, $art;

    public $modal = false;

    public $detalle_diagnostico, $fecha_atencion_enfermedad, $fecha_finalizacion_enfermedad, $horas_reposo, $pdf_enfermedad,
        $imgen_enfermedad, $medicacion, $dosis, $detalle_medicacion, $nro_osef, $tipodelicencia, $pacienteId, $patient_disases;



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
        // $this->paciente_enfermedades = $paciente->enfermedades;
    }

    public function editModalDisase($enfermedadeId)
    {
        // Obtenemos las enfermedades del paciente
        $paciente = Paciente::with(['enfermedades' => function ($query) use ($enfermedadeId) {
            $query->where('enfermedades.id', $enfermedadeId);
        }])->find($this->pacienteId);

        // Verificamos si el paciente y la enfermedad existen
        if ($paciente && $paciente->enfermedades->isNotEmpty()) {
            $enfermedade = $paciente->enfermedades->first();

            $this->name = $enfermedade->name;
            // $this->editedDisaseName = $enfermedade->name;
            $this->enfermedade_id = $enfermedade->id;
            $this->fecha_atencion_enfermedad = $enfermedade->pivot->fecha_atencion_enfermedad ?? null;
            $this->detalle_medicacion = $enfermedade->pivot->detalle_medicacion ?? null;
            $this->fecha_finalizacion_enfermedad = $enfermedade->pivot->fecha_finalizacion_enfermedad ?? null;
            $this->horas_reposo = $enfermedade->pivot->horas_reposo ?? null;
            $this->medicacion = $enfermedade->pivot->medicacion ?? null;
            $this->dosis = $enfermedade->pivot->dosis ?? null;
            $this->nro_osef = $enfermedade->pivot->nro_osef ?? null;
            $this->art = $enfermedade->pivot->art ?? null;
            // $this->estado_enfermedad = $enfermedade->pivot->estado_enfermedad ?? null;
            $this->detalle_diagnostico = $enfermedade->pivot->detalle_diagnostico ?? null;
            $this->tipodelicencia = $enfermedade->pivot->tipodelicencia ?? null;
            $this->modal = true;
        }
    }



    public function editDisase()
    {
        $data = $this->validate();

        // Encuentra el paciente
        $paciente = Paciente::find($this->pacienteId);

        // Encuentra la enfermedad del paciente
        $enfermedade = $paciente->enfermedades()->findOrFail($this->enfermedade_id);

        // Directorio para almacenar los archivos
        $directoryPath = "public/archivos_enfermedades/paciente_{$paciente->id}";

        // Si se proporciona un nuevo archivo, guárdalo y actualiza la ruta
        if (isset($data['imgen_enfermedad'])) {
            $archivoPath = $data['imgen_enfermedad']->storeAs($directoryPath, $data['imgen_enfermedad']->getClientOriginalName());

            // Validar si es una imagen (puedes expandir esto según tus necesidades)
            if (!str_starts_with($data['imgen_enfermedad']->getMimeType(), 'image/')) {
                $this->addError('imgen_enfermedad', 'El imgen_enfermedad debe ser una imagen.');
                return;
            }
        } else {
            $archivoPath = $enfermedade->pivot->imgen_enfermedad;
        }

        // Si se proporciona un nuevo archivo, guárdalo y actualiza la ruta
        if (isset($data['pdf_enfermedad'])) {
            // Validar si es un archivo PDF
            if ($data['pdf_enfermedad']->getMimeType() !== 'application/pdf') {
                $this->addError('pdf_enfermedad', 'El pdf_enfermedad debe ser un archivo PDF.');
                return;
            }

            $archivoPathDorso = $data['pdf_enfermedad']->storeAs($directoryPath, $data['pdf_enfermedad']->getClientOriginalName());
        } else {
            $archivoPathDorso = $enfermedade->pivot->pdf_enfermedad;
        }

        // Actualiza los atributos del modelo Paciente
        $enfermedade->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        // Actualiza los atributos del modelo Pivot
        $enfermedade->pivot->update([
            'fecha_atencion_enfermedad' => $data['fecha_atencion_enfermedad'],
            'detalle_medicacion' => $data['detalle_medicacion'],
            'detalle_diagnostico' => $data['detalle_diagnostico'],
            'imgen_enfermedad' => $archivoPath,
            'pdf_enfermedad' => $archivoPathDorso,
            'fecha_finalizacion_enfermedad' => $data['fecha_finalizacion_enfermedad'],
            'horas_reposo' => $data['horas_reposo'],
            'nro_osef' => $data['nro_osef'],
            'art' => $data['art'],
            'medicacion' => $data['medicacion'],
            'dosis'=> $data['dosis'],
            'tipodelicencia' => $data['tipodelicencia'],
        ]);

        // Cerrar el modal y limpiar los datos
        $this->modal = false;
        $this->reset([
            'name',
            // 'editedDisaseName',
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
            'search'
        ]);

        // Recargar las enfermedades del paciente
        $this->patient_disases = $paciente->enfermedades()->get();
        $this->resetValidation();
        $this->render();
    }


    public function render()
    {
        // Obtén el paciente actual con sus enfermedades paginadas y con búsqueda
        $paciente = Paciente::find($this->pacienteId);

        // Verifica si el paciente existe
        if ($paciente) {
            // Aplica la paginación y ordena las enfermedades asociadas al paciente con el valor de búsqueda
            $enfermedades = $paciente->enfermedades()
                ->where(function ($query) {
                    // Condición de búsqueda
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('codigo', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.detalle_diagnostico', 'like', '%' . $this->search . '%')
                        // Agrega más condiciones según sea necesario
                        ->orWhere('enfermedade_paciente.detalle_medicacion', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.fecha_finalizacion_enfermedad', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.horas_reposo', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.fecha_atencion_enfermedad', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.medicacion', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.detalle_medicacion', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.nro_osef', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.art', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.tipodelicencia', 'like', '%' . $this->search . '%');
                })
                ->orderBy('enfermedade_paciente.id', $this->sortAsc ? 'desc' : 'asc') // Ordena por ID ascendente o descendente
                ->paginate($this->perPage, ['*'], 'enfermedades_page');

            return view('livewire.patient.patient-historial-enfermedades', [
                'paciente' => $paciente,
                'enfermedades' => $enfermedades,
            ])->layout('layouts.app');
        }

        return view('livewire.patient.patient-historial-enfermedades')->layout('layouts.app');
    }
}
