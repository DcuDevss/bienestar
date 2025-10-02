<?php

namespace App\Livewire\Enfermero;

use App\Models\ControlEnfermero;
use App\Models\Paciente;
use Livewire\Component;

class ControlPaciente extends Component
{
    public $search = '';
    public $perPage = 5;
    public $sortAsc = true;
    public $sortField = 'presion';
    public $presion, $fecha_atencion, $detalles, $glucosa, $paciente_id,
           $inyectable, $dosis, $enfermero_id, $patient_disases, $patient,
           $enfermero, $suma_auxiliar, $enfermeroId, $temperatura, $patient_enfermedades,
           $pacienteId;
    public $modal = false;

    protected $rules = [
        'presion' => 'nullable',
        'fecha_atencion' => 'nullable',
        'temperatura' => 'nullable',
        'glucosa' => 'nullable',
        'detalles' => 'nullable',
        'inyectable' => 'nullable',
        'dosis' => 'nullable',
        'paciente_id' => 'nullable',
    ];

    public function mount(Paciente $paciente)
    {
        $this->pacienteId = $paciente->id;
        $this->patient = $paciente;
       // $this->patient_enfermedades = $paciente->enfermedadPacientess;
    }

    public function addNew()
    {
        $this->modal = true;
    }

    public function createControles()
    {
        $this->validate();

        // Crear el registro de ControlEnfermero
        $control = ControlEnfermero::create([
            'presion' => $this->presion,
            'fecha_atencion' => $this->fecha_atencion,
            'glucosa' => $this->glucosa,
            'temperatura' => $this->temperatura,
            'detalles' => $this->detalles,
            'inyectable' => $this->inyectable,
            'dosis' => $this->dosis,
            'paciente_id' => $this->pacienteId,
        ]);

        // Reiniciar los campos después de la creación del registro
        $this->reset([
            'presion',
            'fecha_atencion',
            'glucosa',
            'temperatura',
            'detalles',
            'inyectable',
            'dosis',
            'paciente_id',
        ]);

        // Cerrar el modal
        $this->modal = false;

        // Mostrar un mensaje de éxito
        session()->flash('message', 'Registro creado exitosamente.');
    }


    public function render()
    {
        return view('livewire.enfermero.control-paciente');
    }
}
