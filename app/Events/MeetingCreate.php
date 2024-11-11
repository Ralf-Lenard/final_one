<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class MeetingCreate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomName;
    public $userId;

    /**
     * Create a new event instance.
     *
     * @param string $roomName
     * @param int $userId
     * @return void
     */
    public function __construct($roomName, $userId)
    {
        $this->roomName = $roomName;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('user.' . $this->userId);
    }

    /**
     * Get the data to broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'roomName' => $this->roomName,
            'message' => "Your meeting ID is <strong>{$this->roomName}</strong> Please keep it confidential and do not share it with others. Thank you!",
        ];
    }
}
