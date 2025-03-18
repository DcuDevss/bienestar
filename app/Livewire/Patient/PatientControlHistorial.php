<?php

namespace App\Livewire\Patient;

use App\Models\Enfermedade;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PatientControlHistorial extends Component
{
    public $paciente;
    public $enfermedade;

    /*public function mount($paciente)
    {
        $this->paciente = $paciente;
        //$this->enfermedade=$enfermedade;
        // Tu lógica para mostrar el control de historial

        // ...

        // return view('patient.patient-control-historial', compact('paciente', 'enfermedade_paciente_id'));
    }*/

    public function historial($paciente_id, $enfermedade_paciente_id)
    {
        $paciente = DB::table('paciente')->find($paciente_id);
        $historial = DB::table('enfermedade_paciente')->find($enfermedade_paciente_id);

        // Realiza cualquier operación adicional aquí

        return view('patient.historial', ['paciente' => $paciente, 'historial' => $historial]);
    }


    public function render()
    {
        return view('livewire.patient.patient-control-historial')->layout('layouts.app');
    }
}
