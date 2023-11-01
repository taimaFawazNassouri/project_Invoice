<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoices;
use App\Models\User;

class sentToData extends Notification
{
    use Queueable;
    private $invoices;


    /**
     * Create a new notification instance.
     */
    public function __construct(Invoices $invoices)
    {
        $this->invoices=$invoices;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
  
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable){
        return [
            'id'=> $this->invoices->id,
            'title'=>'Add Invoice By',
            'user'=>Auth::User()->name,

        ];
    }
}
