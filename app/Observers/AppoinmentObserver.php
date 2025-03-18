<?php

namespace App\Observers;

use App\Models\Appoinment;

class AppoinmentObserver
{
    /**
     * Handle the Appoinment "created" event.
     */
    public function created(Appoinment $appoinment): void
    {
        $appoinment->status = Appoinment::PENDING;//esto sirve para que cada ves q creemos una cita va tener la condicion de pendiente
        $appoinment->save();
    }

    /**
     * Handle the Appoinment "updated" event.
     */
    public function updated(Appoinment $appoinment): void
    {
        //
    }

    /**
     * Handle the Appoinment "deleted" event.
     */
    public function deleted(Appoinment $appoinment): void
    {
        //
    }

    /**
     * Handle the Appoinment "restored" event.
     */
    public function restored(Appoinment $appoinment): void
    {
        //
    }

    /**
     * Handle the Appoinment "force deleted" event.
     */
    public function forceDeleted(Appoinment $appoinment): void
    {
        //
    }
}
