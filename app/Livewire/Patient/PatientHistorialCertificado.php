<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Paciente;
use App\View\Components\EnfermeroLayout;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class PatientHistorialCertificado extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $fecha_presentacion_certificado, $detalle_certificado,$fecha_finalizacion_licencia,$fecha_inicio_licencia,
    $horas_salud,$suma_salud,$estado_certificado,$tipolicencia_id,$imagen_frente,$imagen_dorso,$tipodelicencia,
    $disase_id, $patient_disases, $patient, $disase,$suma_auxiliar;



    public  $fecha_enfermedad, $tipo_enfermedad, $fecha_finalizacion, $fecha_atencion, $activo,
    $paciente_id, $disases,  $archivo;
    public $selectedDisase;
    public $modal = false;
    public $modalEdit = false;
    public $editedDisaseName;
    public $pacienteId;


    public $sortAsc = true;
    #[Url(history:true)]
    public $search = '';

    #[Url(history:true)]
    public $admin = '';

    #[Url(history:true)]
    public $sortBy = 'created_at';

    #[Url(history:true)]
    public $sortDir = 'DESC';

    #[Url()]
    public $perPage = 4;


   // public $sortAsc = true;   //public $sortAsc = true;
   // public $sortField = 'name';

    protected $rules = [
        'name' => 'required',
        'fecha_presentacion_certificado'=>'nullable',
        'detalle_certificado'=>'required',
        'fecha_inicio_licencia'=>'nullable',
        'fecha_finalizacion_licencia'=>'nullable',
        'horas_salud'=>'nullable',
        'suma_salud'=>'nullable',
        //'suma_auxiliar'=>'nullable',
       // 'imagen_frente.*' => 'mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf,docx|max:1024',
        'imagen_frente'=>'nullable|file',
        'imagen_dorso'=>'nullable|file',
        'estado_certificado'=>'nullable',
        'tipodelicencia'=>'nullable',
        'disase_id' => 'required',
        'suma_auxiliar'=>'nullable',



    ];

    public function mount($paciente)
    {
        $this->pacienteId = $paciente;
       // $this->patient_disases = $paciente->disases;
    }

    public function editModalDisase($disaseId)
    {
        // Obtenemos las enfermedades del paciente
        $paciente = Paciente::with(['disases' => function ($query) use ($disaseId) {
            $query->where('disases.id', $disaseId);
        }])->find($this->pacienteId);

        // Verificamos si el paciente y la enfermedad existen
        if ($paciente && $paciente->disases->isNotEmpty()) {
            $disase = $paciente->disases->first();

            $this->name = $disase->name;
            $this->editedDisaseName = $disase->name;
            $this->disase_id = $disase->id;
            $this->fecha_presentacion_certificado = $disase->pivot->fecha_presentacion_certificado ?? null;
            $this->fecha_inicio_licencia = $disase->pivot->fecha_inicio_licencia ?? null;
            $this->fecha_finalizacion_licencia = $disase->pivot->fecha_finalizacion_licencia ?? null;
            $this->horas_salud = $disase->pivot->horas_salud ?? null;
            $this->suma_salud = $disase->pivot->suma_salud ?? null;
            $this->suma_auxiliar = $disase->pivot->suma_auxiliar ?? null;
            $this->estado_certificado = $disase->pivot->estado_certificado ?? null;
            $this->detalle_certificado = $disase->pivot->detalle_certificado ?? null;
            $this->tipodelicencia = $disase->pivot->tipodelicencia ?? null;
            $this->modal = true;
        }
    }


    public function editDisase()
{
    $data = $this->validate();

    // Encuentra el paciente
    $paciente = Paciente::find($this->pacienteId);

    // Encuentra la enfermedad del paciente
    $disase = $paciente->disases()->findOrFail($this->disase_id);

    // Directorio para almacenar los archivos
    $directoryPath = "public/archivos_disases/paciente_{$paciente->id}";

    // Si se proporciona un nuevo archivo, guárdalo y actualiza la ruta
    if (isset($data['imagen_frente'])) {
        $archivoPath = $data['imagen_frente']->storeAs($directoryPath, $data['imagen_frente']->getClientOriginalName());

        // Validar si es una imagen (puedes expandir esto según tus necesidades)
        if (!str_starts_with($data['imagen_frente']->getMimeType(), 'image/')) {
            $this->addError('imagen_frente', 'El imagen_frente debe ser una imagen.');
            return;
        }
    } else {
        $archivoPath = $disase->pivot->imagen_frente;
    }

     // Si se proporciona un nuevo archivo, guárdalo y actualiza la ruta
     if (isset($data['imagen_dorso'])) {
        $archivoPathDorso = $data['imagen_dorso']->storeAs($directoryPath, $data['imagen_dorso']->getClientOriginalName());

        // Validar si es una imagen (puedes expandir esto según tus necesidades)
        if (!str_starts_with($data['imagen_dorso']->getMimeType(), 'image/')) {
            $this->addError('imagen_dorso', 'El imagen_dorso debe ser una imagen.');
            return;
        }
    } else {
        $archivoPathDorso = $disase->pivot->imagen_dorso;
    }
    // Actualiza los atributos del modelo Paciente
    $disase->update([
        'name' => $this->editedDisaseName,
        'slug' => Str::slug($this->editedDisaseName),
    ]);

    // Actualiza los atributos del modelo Pivot
    $disase->pivot->update([
        'fecha_presentacion_certificado' => $data['fecha_presentacion_certificado'],
        'fecha_inicio_licencia' => $data['fecha_inicio_licencia'],
        'detalle_certificado' => $data['detalle_certificado'],
        'imagen_frente' => $archivoPath,
        'imagen_dorso' => $archivoPathDorso,
        'fecha_finalizacion_licencia' => $data['fecha_finalizacion_licencia'],
        'horas_salud' => $data['horas_salud'],
        'suma_salud' => $data['suma_salud'],
        'suma_auxiliar' => $data['suma_salud'],
        'estado_certificado' => isset($data['estado_certificado']) ? $data['estado_certificado'] : true,
        'tipodelicencia' => $data['tipodelicencia'],
    ]);

    // Cerrar el modal y limpiar los datos
    $this->modal = false;
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
        'tipodelicencia',
        'estado_certificado',
        'imagen_frente',
        'imagen_dorso',
        'search'
    ]);

    // Recargar las enfermedades del paciente
    $this->patient_disases = $paciente->disases()->get();
    $this->resetValidation();
    $this->render();
}


public function updatedSearch(){
    $this->resetPage();
}

public function delete(Paciente $paciente){
    $paciente->delete();
}

public function setSortBy($sortByField){

    if($this->sortBy === $sortByField){
        $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
        return;
    }

    $this->sortBy = $sortByField;
    $this->sortDir = 'DESC';
}


public function render()
{
    // Obtén el paciente actual con sus enfermedades paginadas y con búsqueda
    $paciente = Paciente::find($this->pacienteId);

    // Verifica si el paciente existe
    if ($paciente) {
        // Aplica la paginación a las enfermedades asociadas al paciente con el valor de búsqueda
        $enfermedades = $paciente->disases()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('disase_paciente.detalle_certificado', 'like', '%' . $this->search . '%')
                    ->orWhere('disase_paciente.fecha_inicio_licencia', 'like', '%' . $this->search . '%')
                    ->orWhere('disase_paciente.fecha_finalizacion_licencia', 'like', '%' . $this->search . '%')
                    ->orWhere('disase_paciente.horas_salud', 'like', '%' . $this->search . '%')
                    ->orWhere('disase_paciente.fecha_presentacion_certificado', 'like', '%' . $this->search . '%')
                    ->orWhere('disase_paciente.estado_certificado', 'like', '%' . $this->search . '%')
                    ->orWhere('disase_paciente.suma_auxiliar', 'like', '%' . $this->search . '%')
                    ->orWhere('disase_paciente.tipodelicencia', 'like', '%' . $this->search . '%');
                    // Agrega más columnas según sea necesario
                    //->orWhere('disase_paciente.otra_columna', 'like', '%' . $this->search . '%');
            })
            ->orderBy('disase_paciente.id', $this->sortAsc ? 'desc' : 'asc')
            ->paginate($this->perPage, ['*'], 'enfermedades_page');

        return view('livewire.patient.patient-historial-certificado', [
            'paciente' => $paciente,
            'enfermedades' => $enfermedades,
        ])->layout('layouts.app');
    }

    // Si el paciente no existe
    return view('livewire.patient.patient-historial-certificado')->layout('layouts.app');
}



}
