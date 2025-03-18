<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\File;

class PatientInfo extends Component
{
    use WithPagination;

    protected $listeners =['actualizar'=>'actualizar'];

    public function actualizar(){
    $this->render();
   }

    public function render()
    {
        $desde = today();
        $hasta = now()->addDays(15);
        $anterior = now()->subDays(90);

        $appoinments = auth()->user()
        ->appoinments()->whereBetween('date',[$desde,$hasta])->get();
        //dd($desde,$hasta,$appoinments);
        $interviews = auth()->user()
        ->interviews()->whereBetween('date',[$anterior,$hasta])->get();


        $files = File::whereHas('interviews',function($q){
            $q->where('user_id','=',auth()->user()->id);
        })->paginate(2);

        $this->resetPage();
        $medicines = auth()->user()->medicines()->withPivot('dosage','instruction')->get();
        //dd($medicines,auth()->user()->id);

        return view('livewire.patient.patient-info',compact('appoinments','interviews','files','medicines'));
    }
}
