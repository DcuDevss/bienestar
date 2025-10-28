<?php

namespace App\Livewire\Patient;

use Livewire\Component;

class PatientHistorial extends Component
{
    public $paciente;
    public $tratamiento;

public function mount($paciente, $tratamiento)
{
    $this->paciente = $paciente;
    $this->tratamiento = $tratamiento;

    // Aquí puedes realizar lógica adicioonal si es necesario al cargar el componente
}

    public function render()
    {
        return view('livewire.patient.patient-historial')->layout('layouts.app');
    }
}
