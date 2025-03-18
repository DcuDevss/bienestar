<?php

namespace App\Notifications;

use App\Models\Appoinment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppoinmentStatusCancelNotification extends Notification
{
    use Queueable;
    protected $appoinment; // Agrega esta línea


    /**
     * Create a new notification instance.
     */
    public function __construct(Appoinment $appoinment) // Agrega el parámetro aquí
    {
        $this->appoinment = $appoinment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->line('Cancelado.')
        ->action('Notification Action', url('/'))
        ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
