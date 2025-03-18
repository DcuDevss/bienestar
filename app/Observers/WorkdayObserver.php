<?php

namespace App\Observers;

use App\Models\Diadetrabajo;

class WorkdayObserver
{
    /**
     * Handle the Diadetrabajo "created" event.
     */
    public function created(Diadetrabajo $diadetrabajo): void
    {
        //
    }

    /**
     * Handle the Diadetrabajo "updated" event.
     */
    public function updating(Diadetrabajo $diadetrabajo): void
    {
        if($diadetrabajo->morning_start>$diadetrabajo->morning_end){$diadetrabajo->morning_start=13; $diadetrabajo->morning_end=13;}
       if($diadetrabajo->afternoon_start>$diadetrabajo->afternoon_end){$diadetrabajo->afternoon_start=25; $diadetrabajo->afternoon_end=25;}
       if($diadetrabajo->evening_start>$diadetrabajo->evening_end){$diadetrabajo->evening_start=37; $diadetrabajo->evening_end=37;}
    }

    /**
     * Handle the Diadetrabajo "deleted" event.
     */
    public function deleted(Diadetrabajo $diadetrabajo): void
    {
        //
    }

    /**
     * Handle the Diadetrabajo "restored" event.
     */
    public function restored(Diadetrabajo $diadetrabajo): void
    {
        //
    }

    /**
     * Handle the Diadetrabajo "force deleted" event.
     */
    public function forceDeleted(Diadetrabajo $diadetrabajo): void
    {
        //
    }
}
