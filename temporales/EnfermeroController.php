<?php

namespace App\Livewire\Enfermero;

use App\Models\Enfermero;
use App\Models\Paciente;
use Livewire\Component;

class EnfermeroController extends Component
{
    //use WithFileUploads;
    public $search = '';
    public $perPage = 5;
    public $sortAsc = true;
    public $sortField = 'presion';
    //public $enfermeroId;
    public $presion, $fecha_atencion, $detalles,$glucosa,
    $inyectable,$dosis,$enfermero_id, $patient_disases, $patient, $enfermero,$suma_auxiliar,$enfermeroId;

    public $modal = false;

    protected $rules = [
        'presion' => 'required',
        'fecha_atencion'=>'nullable',
        'detalles'=>'nullable',
        'glucosa'=>'nullable',
        'inyectable'=>'nullable',
        'dosis'=>'nullable',
        'enfermero_id' => 'required',






    ];

    public function mount(Paciente $paciente)
    {
        $this->patient = $paciente;
        $this->patient_disases = $paciente->enfermeros;
    }

   public function addModalEnfermero($enfermeroId)
    {
        $enfermero = Enfermero::find($enfermeroId);
        $this->presion = $enfermero->presion;
        $this->enfermero_id = $enfermero->id;
        $this->modal = true;
    }


    public function addEnfermero()
{
    $data = $this->validate();

    // Obtener el ID del paciente
    $patientId = $this->patient->id;

    // Crear el directorio si no existe
   /* $directoryPath = "public/archivos_disases/paciente_$patientId";
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
    }*/

    $this->patient->enfermeros()->attach($data['enfermero_id'], [
        'fecha_atencion' => $data['fecha_atencion'],
        'glucosa' => $data['glucosa'],
        'detalles' => $data['detalles'],
        //'imagen_frente' => $archivoPath,
        //'imagen_dorso' => $archivoPathDorso,
        'inyectable' => $data['inyectable'],
        'dosis' => $data['dosis'],
        //'suma_salud' => $data['suma_salud'],
        //'suma_auxiliar' => $data['suma_salud'],
        //'estado_certificado' => isset($data['estado_certificado']) ? $data['estado_certificado'] : true, // O ajusta según tus necesidades
        //'tipodelicencia' => $data['tipodelicencia']
        //'tipolicencia_id' => $data['tipolicencia_id'],
    ]);

    $this->modal = false;
    $this->reset([
        'presion',
        'fecha_atencion',
        'detalles',
        'glucosa',
        'inyectable',
        'dosis',
       /* 'suma_salud',
        'suma_auxiliar',
        'tipolicencia_id',
        'tipodelicencia',
        'estado_certificado',
        'imagen_frente',
        'imagen_dorso',*/
        'search'
    ]);
    $this->patient_disases = $this->patient->enfermeros()->get();
    $this->resetValidation();
    $this->render();
}


    public function addNew()
    {
        $newEnfermero = Enfermero::create([
            'presion' => mb_strtolower($this->search),
            //'slug' => Str::slug($this->search),
            //'symptoms' => '',
        ]);
        $this->enfermero = $newEnfermero;
        $this->presion = $newEnfermero->presion;
        $this->addModalEnfermero($newEnfermero->id);
    }


    public function render()
    {
       // $tipolicencias = Tipolicencia::all();  // Asegúrate de importar el modelo al principio del imagen_frente

       if ($this->search) {
            $enfermeros = Enfermero::search($this->search)->get();
        } else {
            $enfermeros = [];
        }


        return view('livewire.enfermero.enfermero-controller', ['enfermeros' => $enfermeros]);
    }
}
