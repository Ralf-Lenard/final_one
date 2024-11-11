<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbuseApprove extends Notification
{
    use Queueable;

    protected $abuses;

    public function __construct($abuses)
    {
        $this->abuses = $abuses;
    }

    public function via($notifiable)
    {
        return ['database']; // Store notification in the database
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your animal abuse report is approved. Please wait for the announcement with the scheduled date and time for the virtual meeting.',
        ];
    }
}