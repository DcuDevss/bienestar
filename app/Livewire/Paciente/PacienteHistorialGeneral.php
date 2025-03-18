<?php

namespace App\Livewire\Paciente;

use App\Models\Enfermedade_paciente;
use Livewire\Component;
use App\Models\Enfermedade;
use App\Models\Paciente;
use Illuminate\Support\Str;
use App\Models\Tipolicencia;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class PacienteHistorialGeneral extends Component
{





public function render()
{
    return view('livewire.paciente.paciente-historial-general');
}



}


