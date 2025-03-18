<?php

namespace App\Livewire\Patient;

use App\Models\Paciente;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class PatientListfechas extends Component
{
    use WithPagination;


    #[Url(history:true)]
    public $search = '';

    #[Url(history:true)]
    public $admin = '';




    // ... (otros métodos)

    public function getPatientsWithTodayFinalization()
    {
        return Paciente::whereHas('disases', function ($query) {
            $query->whereDate('disase_paciente.fecha_finalizacion_licencia', now()->toDateString());
        })->get();
    }



    public function render()
    {
        return view('livewire.patient.patient-listfechas', [

            'pacientesConFinalizacionHoy' => $this->getPatientsWithTodayFinalization(),
            ]);
    }
}
