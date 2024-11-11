<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class AnimalAbuseReportSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $report;
     // Add this property to hold the user's name

    public function __construct($report)
    {
        $this->report = $report;
      // Store the user's name
    }

    public function broadcastOn()
    {
        return new Channel('abuse-reports');
    }

    public function broadcastAs()
    {
        return 'AnimalAbuseReportSubmitted';
    }

    public function broadcastWith()
    {
        return [
            'report' => $this->report,
            'reporter_name' => $this->report->reporter_name, // Include the reporter's name
        ];
    }
    
}