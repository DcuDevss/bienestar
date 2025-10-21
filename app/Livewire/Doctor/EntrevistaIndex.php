<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Entrevista;
use App\Models\Paciente;

class EntrevistaIndex extends Component
{
    public $paciente_id;
    public $entrevistas;
    public $paciente;

    public function mount($paciente_id)
    {
        $this->paciente_id = $paciente_id; // Recibe el paciente_id de la URL
        // Carga las entrevistas del paciente ok
        $this->paciente = Paciente::find($paciente_id);
        $this->entrevistas = Entrevista::where('paciente_id', $this->paciente_id)->get();
        $this->entrevistas = Entrevista::with('grupoFamiliar') // Asegúrate de que la relación 'grupoFamiliar' esté definida en el modelo Entrevista
            ->where('paciente_id', $this->paciente_id) // Filtra las entrevistas por paciente_id
            ->get();

        if (!$this->paciente) {
            session()->flash('error', 'El paciente no existe.');

        }
    }

    public function render()
    {
        return view('livewire.doctor.entrevista-index', [
            'entrevistas' => $this->entrevistas, // Pasa las entrevistas a la vista
            'paciente' => $this->paciente,
        ])->layout('layouts.app');;
    }
}
