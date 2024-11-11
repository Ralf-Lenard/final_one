<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class MeetingCreated extends Notification 
{
    use Queueable;

    protected $roomName;

    /**
     * Create a new notification instance.
     *
     * @param string $roomName
     */
    public function __construct($roomName) {
        $this->roomName = $roomName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable) {
        // This will send a notification via both database and broadcast if needed
        return ['database', 'broadcast']; // Optionally add 'mail' or 'broadcast' as needed
    }

    /**
     * Get the array representation of the notification to store in the database.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            'room_name' => $this->roomName,
            'message' => "Your meeting ID is <strong>{$this->roomName}</strong> Please keep it confidential and do not share it with others. Thank you!",
            'action_url' => url("/admin-meeting/{$this->roomName}"),
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param mixed $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable) {
        return new BroadcastMessage([
            'room_name' => $this->roomName,
            'message' => "Your meeting ID is <strong>{$this->roomName}</strong> Please keep it confidential and do not share it with others. Thank you!",
            'action_url' => url("/admin-meeting/{$this->roomName}"),
        ]);
    }
}
