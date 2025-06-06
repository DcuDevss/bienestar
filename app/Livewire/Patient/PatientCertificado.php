<?php

namespace App\Livewire\Patient;

use App\Models\Disase;
use App\Models\Paciente;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Tipolicencia;
use Livewire\WithFileUploads;


class PatientCertificado extends Component
{
    use WithFileUploads;
    public $search = '';
    public $perPage = 5;
    public $sortAsc = true;
    public $sortField = 'name';
    public $disaseId;
    public $name, $fecha_presentacion_certificado, $detalle_certificado,$fecha_finalizacion_licencia,$fecha_inicio_licencia,
    $horas_salud,$suma_salud,$estado_certificado,$tipolicencia_id,$imagen_frente,$imagen_dorso,$tipodelicencia,
    $disase_id, $patient_disases, $patient, $disase,$suma_auxiliar;

    public $modal = false;

    protected $rules = [
        'name' => 'required',
        /*'fecha_presentacion_certificado' => 'nullable',
        'fecha_atencion' => 'nullable',
        'tipo_enfermedad' => 'required',
        'disase_id' => 'required',
        'archivo' => 'nullable|file',
        'fecha_finalizacion' => 'nullable',
        'horas_salud' => 'nullable',
        'activo' => 'nullable',
        'tipolicencia_id' => 'nullable',
        'tipodelicencia' => 'nullable',*/

        'fecha_presentacion_certificado'=>'nullable',
        'detalle_certificado'=>'required',
        'fecha_inicio_licencia'=>'nullable',
        'fecha_finalizacion_licencia'=>'nullable',
        'horas_salud'=>'nullable',
        'suma_salud'=>'nullable',
        'suma_auxiliar'=>'nullable',
        'imagen_frente'=>'nullable|file',
        'imagen_dorso'=>'nullable|file',
        'estado_certificado'=>'nullable',
        //'tipodelicencia'=>'nullable',
        'tipolicencia_id' => 'required',
        'disase_id' => 'required',


    ];

    public function mount(Paciente $paciente)
    {
        $this->patient = $paciente;
        $this->patient_disases = $paciente->disases;
    }

   public function addModalDisase($disaseId)
    {
        $disase = Disase::find($disaseId);
        $this->name = $disase->name;
        $this->disase_id = $disase->id;
        $this->modal = true;
    }


    public function addDisase()
{
    $data = $this->validate();

    // Obtener el ID del paciente
    $patientId = $this->patient->id;

    // Crear el directorio si no existe
    $directoryPath = "public/archivos_disases/paciente_$patientId";
    if (!file_exists($directoryPath)) {
        mkdir($directoryPath, 0777, true);
    }

    // Manejar la carga del archivo
    if (isset($data['imagen_frente'])) {
        $archivoPath = $data['imagen_frente']->storeAs($directoryPath, $data['imagen_frente']->getClientOriginalName());
    } else {
        $archivoPath = null;
    }

    if (isset($data['imagen_dorso'])) {
        $archivoPathDorso = $data['imagen_dorso']->storeAs($directoryPath, $data['imagen_dorso']->getClientOriginalName());
    } else {
        $archivoPathDorso = null;
    }

    $this->patient->disases()->attach($data['disase_id'], [
        'fecha_presentacion_certificado' => $data['fecha_presentacion_certificado'],
        'fecha_inicio_licencia' => $data['fecha_inicio_licencia'],
        'detalle_certificado' => $data['detalle_certificado'],
        'imagen_frente' => $archivoPath,
        'imagen_dorso' => $archivoPathDorso,
        'fecha_finalizacion_licencia' => $data['fecha_finalizacion_licencia'],
        'horas_salud' => $data['horas_salud'],
        'suma_salud' => $data['suma_salud'],
        'suma_auxiliar' => $data['suma_salud'],
        'estado_certificado' => isset($data['estado_certificado']) ? $data['estado_certificado'] : true, // O ajusta según tus necesidades
        //'tipodelicencia' => $data['tipodelicencia']
        //'tipolicencia_id' => $data['tipolicencia_id'],
        'tipolicencia_id' => $this->tipolicencia_id,

    ]);

    $this->modal = false;
    $this->reset([
        'name',
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
    $this->patient_disases = $this->patient->disases()->get();
    $this->resetValidation();
    $this->render();
}

public function updatedFechaInicioLicencia()
{
    $this->calcularDiasLicencia();
}

public function updatedFechaFinalizacionLicencia()
{
    $this->calcularDiasLicencia();
}

public function calcularDiasLicencia()
{
    if ($this->fecha_inicio_licencia && $this->fecha_finalizacion_licencia) {
        $inicio = \Carbon\Carbon::parse($this->fecha_inicio_licencia);
        $fin = \Carbon\Carbon::parse($this->fecha_finalizacion_licencia);

        if ($inicio->lte($fin)) {
            $this->suma_salud = $inicio->diffInDays($fin) + 1; // incluye ambos días
        } else {
            $this->suma_salud = null;
        }
    } else {
        $this->suma_salud = null;
    }
}



    public function addNew()
    {
        $newDisase = Disase::create([
            'name' => mb_strtolower($this->search),
            'slug' => Str::slug($this->search),
            'symptoms' => '',
        ]);
        $this->disase = $newDisase;
        $this->name = $newDisase->name;
        $this->addModalDisase($newDisase->id);
    }

    public function render()
    {
        $tipolicencias = Tipolicencia::all();  // Asegúrate de importar el modelo al principio del imagen_frente

       if ($this->search) {
            $disases = Disase::search($this->search)->get();
        } else {
            $disases = [];
        }


        return view('livewire.patient.patient-certificado', ['disases' => $disases, 'tipolicencias' => $tipolicencias]);
    }
}
