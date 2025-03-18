<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Enfermedade;
use App\Models\Paciente;
use Illuminate\Support\Str;
use App\Models\Tipolicencia;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class PatientHistorialGeneral extends Component
{
    public function render()
    {


        return view('livewire.patient.patient-historial-general');
    }
}
