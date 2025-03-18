<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Interview;
use App\Models\Symptom;
use App\Models\Paciente;
use Livewire\Attributes\On;

class PatientInterview extends Component
{
    public $date,$suspicion,$diagnosis,$symptoms;
    public $symptoms_text=[];
    public $symptoms_id=[];
    public $medicines_id=[];
    public $patient;

    protected $listeners = ['select'=>'select'];

    //protected $listeners=['reload'=>'reload'];

   // #[On('select')]

    public function mount(Paciente $paciente){
        $this->patient = $paciente;
    }

    protected $rules = ['date'=>'required','suspicion'=>'nullable','diagnosis'=>'required'];

    public function select($ids){
       $this->symptoms = Symptom::orderBy('name','asc')->whereIn('id',$ids)->pluck('name','id');
       $this->symptoms_text = Symptom::orderBy('name','asc')->whereIn('id',$ids)->pluck('name');
       $this->symptoms_id = Symptom::orderBy('name','asc')->whereIn('id',$ids)->pluck('id');
    }

    public function save(){
        $data = $this->validate();
        $interview = Interview::create([
            'date'=>$data['date'],
            'suspicion'=>$data['suspicion'],
            'diagnosis'=>$data['diagnosis'],
            'paciente_id'=>$this->patient->id,
            'doctor_id'=>auth()->user()->id,
        ]);

        $this->patient->symptoms()->attach($this->symptoms_id,['interview_id'=>$interview->id]);

        return redirect()->route('interviews.detail',$interview->id);
    }





    public function render()
    {
        return view('livewire.patient.patient-interview');
    }
}
