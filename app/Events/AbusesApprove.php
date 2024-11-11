<?php

namespace App\Events;

use \App\Models\AnimalAbuseReport;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AbusesApprove implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $abuses;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\AdoptionRequest  $adoptionRequest
     * @return void
     */
    public function __construct(AnimalAbuseReport $abuses)
    {
        $this->abuses = $abuses;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('user.' . $this->abuses->user_id);
    }

    /**
     * Get the data to broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
          'message' => 'Your animal abuse report is approved. Please wait for the announcement with the scheduled date and time for the virtual meeting.',
        ];
    }
}