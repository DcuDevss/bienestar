<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Doctor;

class PatientDoctor extends Component
{
    use WithPagination;
    public $search="";

    public function selectDate($doctorId,$specialtyId){
       // $this->emitTo('patient.patient-date','selectDate',$doctorId,$specialtyId);
        $this->dispatch('selectDate',$doctorId,$specialtyId);
    }

    public function render()
    {
        $search = '%'.$this->search.'%';
        $doctors = Doctor::orderBy('name')->where('name','like',$search)->paginate(4);
        return view('livewire.patient.patient-doctor',['doctors'=>$doctors]);
    }
}
