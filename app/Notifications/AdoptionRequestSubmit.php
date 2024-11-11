<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdoptionRequestSubmit extends Notification
{
    use Queueable;

    protected $adoptionRequest;

    // Constructor to accept adoption request data
    public function __construct($adoptionRequest)
    {
        $this->adoptionRequest = $adoptionRequest;
    }

    // Define the channels this notification should go through
    public function via($notifiable)
    {
        return ['database']; // Store notification in the database
    }

    // Define the array representation of the notification (used for database storage)
    public function toArray($notifiable)
    {
        return [
            'animalName'  => $this->adoptionRequest['animalName'], // Animal's name
            'first_name'  => $this->adoptionRequest['first_name'], // Applicant's first name
            'last_name'   => $this->adoptionRequest['last_name'],  // Applicant's last name
            'message'     => $this->adoptionRequest['message'],    // Custom message about the request
        ];
    }
}
