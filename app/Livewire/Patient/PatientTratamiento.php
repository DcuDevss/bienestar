<?php

namespace App\Livewire\Patient;

use App\Models\Derivacionpsiquiatrica;
use App\Models\Enfermedade;
use App\Models\Indicacionterapeutica;
use App\Models\Procedencia;
use App\Models\Tipolicencia;
use App\Models\Tratamiento;
use Livewire\Component;
use App\Models\Paciente;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class PatientTratamiento extends Component
{
    public $profesional_actual;
    public $consumo_farmacos;
    public $antecedente_familiar;
    public $fecha_inicio;
    public $profesional_enterior;
    public $fecha_atencion;
    public $motivo_consulta_anterior;
    public $motivo_consulta_actual;
    public $tipolicencia_id;
    public $indicacionterapeutica_id;
    public $derivacionpsiquiatrica_id;
    public $procedencia_id;
    public $enfermedade_id;
    public $paciente_id;

    public $tipolicencias=[];
    public $procedencias=[];
    public $indicacionterapeuticas=[];
    public $derivacionpsiquiatricas=[];
    public $enfermedades=[];
    public $patient;
    //public $pacienteId;

    use WithPagination;


    #[Url(history:true)]
    public $search = '';

    #[Url(history:true)]
    public $admin = '';

    #[Url(history:true)]
    public $sortBy = 'id';

    #[Url(history:true)]
    public $sortDir = 'ASC';

    #[Url()]
    public $perPage = 8;

    public $pacienteId;




    protected $rules = [
       // 'profesional_actual' => 'nullable|string',
        'consumo_farmacos' => 'nullable|string',
        'antecedente_familiar' => 'nullable|string',
        'fecha_atencion' => 'nullable|date',
        'profesional_enterior' => 'nullable|string',
        //'fecha_anterior' => 'nullable|date',
        'motivo_consulta_anterior' => 'nullable|string',
        //'motivo_consulta_actual' => 'nullable|string',
        'tipolicencia_id' => 'nullable',
        'indicacionterapeutica_id' => 'nullable',
        'derivacionpsiquiatrica_id' => 'nullable',
        'procedencia_id' => 'nullable',
        'enfermedade_id' => 'nullable',
        'paciente_id' => 'nullable',
    ];

    public function mount(Paciente $paciente)
    {
       // $this->step = 0;
        $this->tipolicencias = Tipolicencia::all(); // Obtener todos los estados
        $this->procedencias = Procedencia::all();
        $this->derivacionpsiquiatricas = Derivacionpsiquiatrica::all();
        $this->indicacionterapeuticas = Indicacionterapeutica::all();
        $this->enfermedades = Enfermedade::all();

        $this->pacienteId = $paciente->id;
        $this->patient = $paciente;

    }

    public function save()
    {
        $this->validate();

        $tratamiento = new Tratamiento();
       // $tratamiento->profesional_actual = $this->profesional_actual;
        $tratamiento->consumo_farmacos = $this->consumo_farmacos;
        $tratamiento->antecedente_familiar = $this->antecedente_familiar;
        $tratamiento->fecha_atencion = $this->fecha_atencion;
        $tratamiento->profesional_enterior = $this->profesional_enterior;
        //$tratamiento->fecha_anterior = $this->fecha_anterior;
        $tratamiento->motivo_consulta_anterior = $this->motivo_consulta_anterior;
      //  $tratamiento->motivo_consulta_actual = $this->motivo_consulta_actual;
        $tratamiento->tipolicencia_id = $this->tipolicencia_id;
        $tratamiento->indicacionterapeutica_id = $this->indicacionterapeutica_id;
        $tratamiento->derivacionpsiquiatrica_id = $this->derivacionpsiquiatrica_id;
        $tratamiento->procedencia_id = $this->procedencia_id;
        $tratamiento->enfermedade_id = $this->enfermedade_id;
        $tratamiento->paciente_id = $this->pacienteId;

        // Tu lógica para guardar en la base de datos aquí...
        $tratamiento->save();

        // Después de guardar, puedes resetear los campos si lo necesitas
        $this->reset();
    }



    public function render()
    {
       // $tratamientos = Tratamiento::where('paciente_id', $this->pacienteId)->get();

        $query = Tratamiento::where('paciente_id', $this->pacienteId);

    if ($this->search) {
        $query->where(function ($q) {
            $q->where('profecional_enterior', 'like', '%' . $this->search . '%')
                ->orWhere('consumo_farmacos', 'like', '%' . $this->search . '%')
                ->orWhere('fecha_anterior', 'like', '%' . $this->search . '%')
                ->orWhere('entecedente_familiar', 'like', '%' . $this->search . '%');
                //->orWhere('dosis', 'like', '%' . $this->search . '%')
                //->orWhere('fecha_atencion', 'like', '%' . $this->search . '%')
                //->orWhere('detalles', 'like', '%' . $this->search . '%');
        });
    }

    $tratamientos = $query->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);

        return view('livewire.patient.patient-tratamiento', compact('tratamientos'))->layout('layouts.app');
    }

}
