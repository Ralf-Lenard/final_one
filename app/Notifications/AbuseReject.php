<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbuseReject extends Notification
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
            'message' => 'We regret to inform you that your animal abuse report has been rejected due to the following reason: ' . $this->abuses->reason . '.',
        ];
    }
}