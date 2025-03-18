<?php

namespace App\Livewire\Patient;

use App\Models\Especialidade;
use Livewire\Component;
use Livewire\WithPagination;

class PatientSpecialty extends Component
{

    use WithPagination;
    public $search;


    public function selectDate($doctorId,$specialtyId){
       // $this->emitTo('patient.patient-date','selectDate',$doctorId,$specialtyId);
        $this->dispatch('selectDate',$doctorId,$specialtyId);
    }


    public function render()
    {
        $search = '%'.$this->search.'%';
        $specialties = Especialidade::orderBy('name')->where('name','like',$search)->paginate(10);

        return view('livewire.patient.patient-specialty',['specialties'=>$specialties]);
    }
}
