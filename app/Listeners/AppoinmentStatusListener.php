<?php

namespace App\Listeners;

use App\Events\AppoinmentStatusEvent;
use App\Models\Appoinment;
use App\Models\User;
use App\Notifications\AppoinmentStatusCancelNotification;
use App\Notifications\AppoinmentStatusConfirmNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Queue\InteractsWithQueue;

class AppoinmentStatusListener
{
    /**
     * Create the event listener. vamoss
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppoinmentStatusEvent $event): void
    {
        $patient = User::find($event->appoinment->patient_id);
        if ($event->appoinment->status == Appoinment::CONFIRMED) {
            Notification::send($patient, new AppoinmentStatusConfirmNotification($event->appoinment));
        } else {
            Notification::send($patient, new AppoinmentStatusCancelNotification($event->appoinment));
        }
    }
}
