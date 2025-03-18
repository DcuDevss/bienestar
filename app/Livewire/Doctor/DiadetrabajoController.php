<?php

namespace App\Livewire\Doctor;

use App\Models\Diadetrabajo;
use App\Models\Hora;
use App\Models\Oficina;
use Livewire\Component;

class DiadetrabajoController extends Component
{
    public $officesEmpty = false;
    public $day,$ms,$me,$as,$ae,$es,$ee,$mo,$ao,$eo,$mp,$ap,$ep,$dia,$active=false;
    public $offices = [];
    public $morning=[];
    public $afternoon=[];
    public $evening=[];
    public $workdayEditModal=false;

    protected $rules = [
        'day' => 'required',
        'ms' => 'required',
        'me' => 'required',
        'as' => 'required',
        'ae' => 'required',
        'es' => 'required',
        'ee' => 'required',
        'mo' => 'required',
        'ao' => 'required',
        'eo' => 'required',
        'mp' => 'required',
        'ap' => 'required',
        'ep' => 'required',
        //'active' => 'required',
        //'morning_office' => 'required',
        //'afternoon_office' => 'required',
        //'evening_office' => 'required',
        //'local'=>'required',
        //'address'=>'required',
    ];





    public function officesEmptyClose(){
        $this->officesEmpty = false;
        return redirect()->route('doctor.index');
    }

    public function edit($day){
     $morning = Hora::where('turn','morning')->get();
     $afternoon = Hora::where('turn','afternoon')->get();
     $evening = Hora::where('turn','evening')->get();
     $this->morning = $morning;
     $this->afternoon = $afternoon;
     $this->evening = $evening;
     $this->day = $day;
     $workday = Diadetrabajo::where('doctor_id',auth()->user()->id)->where('day',$day)->first();
     $this->ms = $workday->morning_start;
     $this->me = $workday->morning_end;
     $this->as = $workday->afternoon_start;
     $this->ae = $workday->afternoon_end;
     $this->es = $workday->evening_start;
     $this->ee = $workday->evening_end;
     $this->mo = $workday->morning_office;
     $this->ao = $workday->afternoon_office;
     $this->eo = $workday->evening_office;
     $this->mp = $workday->morning_price;
     $this->ap = $workday->afternoon_price;
     $this->ep = $workday->evening_price;
     $this->dia = DIA[$this->day];
     $this->workdayEditModal=true;
    }

    public function update($value)
{

    $data = $this->validate($this->rules);
     $data['active']=$this->active;
    $workday =    Diadetrabajo::updateOrCreate([
             'day'=>$this->day,
             'doctor_id'=>auth()->user()->id,
         ],[

            'active'=>$data['active'],
            'morning_start'=>$this->ms,
            'morning_end'=>$this->me,
            'afternoon_start'=>$this->as,
            'afternoon_end'=>$this->ae,
            'evening_start'=>$this->es,
            'evening_end'=>$this->ee,
            'morning_office'=>$this->mo,
            'afternoon_office'=>$this->ao,
            'evening_office'=>$this->eo,
            'morning_price'=>$this->mp,
            'afternoon_price'=>$this->ap,
            'evening_price'=>$this->ep,
         ]);
         $workday->save();

         $this->workdayEditModal=false;

}

// Dentro de DiadetrabajoController
public function hasOffice($day)
{
    $workday = Diadetrabajo::where('doctor_id', auth()->user()->id)
        ->where('day', $day)
        ->first();

    return $workday && $workday->morning_office;
}

// Dentro de DiadetrabajoController sirve para verificar q turno esta asigando y pintarlo
public function hasAssignedOffice($day, $turn)
{
    $workday = Diadetrabajo::where('doctor_id', auth()->user()->id)
        ->where('day', $day)
        ->first();

    switch ($turn) {
        case 'morning':
            return $workday && $workday->morning_office;
        case 'afternoon':
            return $workday && $workday->afternoon_office;
        case 'evening':
            return $workday && $workday->evening_office;
        default:
            return false;
    }
}



    public function render()
    {
       $offices = Oficina::where('doctor_id',auth()->user()->id)->get();
       if($offices->isEmpty()){
           $this->officesEmpty=true;
       }
       $this->offices = $offices;

       $workdays = Diadetrabajo::where('doctor_id',auth()->user()->id)->get();
       if($workdays->isEmpty()){
            Diadetrabajo::addWorkdays();
    }


        return view('livewire.doctor.diadetrabajo-controller',['offices'=>$offices, 'workdays'=>$workdays])->layout('layouts.app');
    }
}
