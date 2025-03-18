<?php

namespace App\Livewire\Appoinment;

use App\Events\AppoinmentStatusEvent;
use App\Models\Appoinment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AppoinmentList extends Component
{
    use WithPagination;

    public $days = -1;
    public $dateFrom, $dateTo;

    public function mount()
    {
        $this->dateFrom = now()->addDays($this->days);
        $this->dateTo = now();
    }

    public function updatedDays($value)
    {
        $this->days = $value;
        if ($this->days == 0) {
            $this->dateTo = now()->addDays(0);
        } else {
            $this->dateTo = now()->addDays($this->days);
        }
    }


public function confirmed(Appoinment $appoinment){
    $appoinment->status = Appoinment::CONFIRMED;
    $appoinment->save();
    event( new AppoinmentStatusEvent($appoinment));
}

public function canceled(Appoinment $appoinment)
{
    $appoinment->status = Appoinment::CANCELED;
    $appoinment->save();
    event(new AppoinmentStatusEvent($appoinment));
}




// ...

public function render()
{
    $user = auth()->user();
    $isDoctor = $user->hasRole('doctor');

    $find = $isDoctor ? 'doctor_id' : 'patient_id';

    $appoinments = Appoinment::all();


    return view('livewire.appoinment.appoinment-list', compact('appoinments'))->layout('layouts.app');
}


/*use WithPagination;

public $days = -1;
public $dateFrom, $dateTo;

public function mount()
{
    $this->dateFrom = now()->addDays($this->days);
    $this->dateTo = now();
}

public function updatedDays($value)
{
    $this->days = $value;
    if ($this->days == 0) {
        $this->dateTo = now()->addDays(0);
    } else {
        $this->dateTo = now()->addDays($this->days);
    }
}


public function confirmed(Appoinment $appoinment){
$appoinment->status = Appoinment::CONFIRMED;
$appoinment->save();
event( new AppoinmentStatusEvent($appoinment));
}

public function canceled(Appoinment $appoinment){
$appoinment->status = Appoinment::CANCELED;
$appoinment->save();
event( new AppoinmentStatusEvent($appoinment));
}



public function render()
{
    $user = auth()->user();
    $isDoctor = $user->hasRole('doctor');
    if ($isDoctor) {$find = 'doctor_id';} else { $find = 'patient_id';}

    $appoinments = Appoinment::orderBy('date', 'asc')
                   ->whereBetween('date', [$this->dateFrom, $this->dateTo])
                   ->where($find, $user->id)
                   ->where('status',Appoinment::CONFIRMED)
                   ->orWhere('status',Appoinment::PENDING)
                   ->paginate(3);
    return view('livewire.appoinment.appoinment-list', ['appoinments' => $appoinments]);
}*/


}
