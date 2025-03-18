<?php

namespace App\Livewire\Patient;

use App\Models\Disase;
use App\Models\Enfermedade;
use App\Models\Paciente;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Tipolicencia;
use Livewire\WithFileUploads;
use Carbon\Carbon;


class PatientEnfermedade extends Component
{
    use WithFileUploads;
    public $search = '';
    public $perPage = 5;
    public $sortAsc = true;
    public $sortField = 'name';
    public $disaseId;
    public $name, $fecha_enfermedad, $tipo_enfermedad,$fecha_finalizacion,$fecha_atencion,$activo,$tipolicencia_id,
    $disase_id, $paciente_enfermedades, $patient, $disase, $archivo,$enfermedade;

    public $modal = false;

    public $detalle_diagnostico,$fecha_atencion_enfermedad,$fecha_finalizacion_enfermedad,$horas_reposo,$pdf_enfermedad,
    $imgen_enfermedad,$medicacion,$dosis,$detalle_medicacion,$nro_osef,$tipodelicencia,$enfermedade_id,$art,$motivo_consulta,
    $estado_enfermedad,$derivacion_psiquiatrica;



    protected $rules = [
        'name' => 'nullable',
        'detalle_diagnostico'=>'nullable',
        'fecha_atencion_enfermedad'=>'nullable',
        'fecha_finalizacion_enfermedad'=>'nullable',
        'horas_reposo'=>'nullable',
        'pdf_enfermedad'=>'nullable|file|mimes:pdf,png,jpg,jpeg,gif|max:10240',
        'imgen_enfermedad'=>'nullable|file',
        'medicacion'=>'nullable',
        'dosis'=>'nullable',
        'motivo_consulta'=>'nullable',
        'derivacion_psiquiatrica'=>'nullable',
        'estado_enfermedad'=>'nullable',
        'art'=>'nullable',
        'detalle_medicacion'=>'nullable',
        'nro_osef'=>'nullable',
        'tipodelicencia'=>'nullable',
        'enfermedade_id'=>'required',
    ];

   /* public function mount(Paciente $paciente)
    {
        $this->patient = $paciente;
        $this->patient_disases = $paciente->enfermedades;
    }*/

    public function mount(Paciente $paciente)
{
    $this->patient = $paciente;
    $this->paciente_enfermedades = $paciente->enfermedades;
}

   public function addModalDisase($enfermedadeId)
    {
        $enfermedade = Enfermedade::find($enfermedadeId);
        $this->name = $enfermedade->name;
        $this->enfermedade_id = $enfermedade->id;
        $this->modal = true;
    }



public function addDisase()
{
    $data = $this->validate();

    // Obtener el ID del paciente
    $patientId = $this->patient->id;

    // Crear el directorio si no existe
    $directoryPath = "public/archivos_enfermedades/paciente_$patientId";
    if (!file_exists($directoryPath)) {
        mkdir($directoryPath, 0777, true);
    }

    // Manejar la carga del archivo
    if (isset($data['imgen_enfermedad'])) {
        $archivoPathEnfermedad = $data['imgen_enfermedad']->storeAs($directoryPath, $data['imgen_enfermedad']->getClientOriginalName());
    } else {
        $archivoPathEnfermedad = null;
    }

    if (isset($data['pdf_enfermedad'])) {
        $archivoPathPDF = $data['pdf_enfermedad']->storeAs($directoryPath, $data['pdf_enfermedad']->getClientOriginalName());
    } else {
        $archivoPathPDF = null;

    }


    $this->patient->enfermedades()->attach($data['enfermedade_id'], [
        //'fecha_presentacion_certificado' => $data['fecha_presentacion_certificado'],
        'fecha_atencion_enfermedad' => $data['fecha_atencion_enfermedad'],
        'detalle_diagnostico' => $data['detalle_diagnostico'],
        'imgen_enfermedad' => $archivoPathEnfermedad,
        'pdf_enfermedad' => $archivoPathPDF,
        'fecha_finalizacion_enfermedad' => $data['fecha_finalizacion_enfermedad'],
        'horas_reposo' => $data['horas_reposo'],
        'medicacion' => $data['medicacion'],
        'dosis' => $data['dosis'],
        'motivo_consulta' => $data['motivo_consulta'],
        'derivacion_psiquiatrica' => $data['derivacion_psiquiatrica'],
        'estado_enfermedad'=>$data['estado_enfermedad'],
        'detalle_medicacion' => $data['detalle_medicacion'],
        'nro_osef' => $data['nro_osef'],
        'tipodelicencia' => $data['tipodelicencia'],
        'art' => $data['art']
    ]);

    $this->modal = false;
    $this->reset([
        'name',
        //'fecha_presentacion_certificado',
        'detalle_diagnostico',
        'fecha_atencion_enfermedad',
        'fecha_finalizacion_enfermedad',
        'horas_reposo',
        'dosis',
        'tipolicencia_id',
        'tipodelicencia',
        'art',
        'motivo_consulta',
        'derivacion_psiquiatrica',
        'estado_enfermedad',
        'imgen_enfermedad',
        'medicacion',
        'detalle_medicacion',
        'pdf_enfermedad',
        'nro_osef',
        'pdf_enfermedad',
        'search'
    ]);
    $this->paciente_enfermedades = $this->patient->enfermedades()->get();
    $this->resetValidation();
    $this->render();
}



    public function addNew()
    {
        $newDisase = Enfermedade::create([
            'name' => mb_strtolower($this->search),
            'slug' => Str::slug($this->search),
            'codigo' => '',
        ]);
        $this->enfermedade = $newDisase;
        $this->name = $newDisase->name;
        $this->addModalDisase($newDisase->id);
    }




    public function render()
    {
        $tipolicencias = Tipolicencia::all();

        if ($this->search) {
            $enfermedades = Enfermedade::search($this->search)->take(10)->get();
        } else {
            $enfermedades = [];
        }

        return view('livewire.patient.patient-enfermedade', ['enfermedades' => $enfermedades, 'tipolicencias' => $tipolicencias]);
    }


}
