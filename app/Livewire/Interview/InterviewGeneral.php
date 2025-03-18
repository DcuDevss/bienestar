<?php

namespace App\Livewire\Interview;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InterviewGeneral extends Component
{
    public function resetGeneral()
    {
        // Actualizar el campo suma_salud a 0 para todos los registros en la tabla intermedia
        DB::table('disase_paciente')->update(['suma_salud' => 0]);

        // Mostrar mensaje de éxito
        session()->flash('success', 'Sumas reiniciadas correctamente.');
    }

    public function render()
    {
        return view('livewire.interview.interview-general');
    }
}
