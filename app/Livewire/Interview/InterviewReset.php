<?php

namespace App\Livewire\Interview;

use App\Models\Paciente;
use Livewire\Component;

class InterviewReset extends Component
{
    public Paciente $paciente;

    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;
    }

    public function resetSums()
    {
        $this->paciente->disases()->where('tipodelicencia', '!=', 'Atención familiar')->update(['suma_salud' => 0]);

        session()->flash('success', 'Sumas reiniciadas correctamente.');
    }

    public function resetSumsAtendibles()
    {
        $this->paciente->disases()->where('tipodelicencia', 'Atención familiar')->update(['suma_salud' => 0]);

        session()->flash('success', 'Sumas reiniciadas correctamente.');
    }

    public function resetGeneral()
    {
        $this->paciente->disases()->where('tipodelicencia', 'Atención familiar')->update(['suma_salud' => 0]);
        $this->paciente->disases()->where('tipodelicencia', '!=', 'Atención familiar')->update(['suma_salud' => 0]);

        session()->flash('success', 'Sumas reiniciadas correctamente.');
    }





    public function render()
    {
        return view('livewire.interview.interview-reset');
    }
}
