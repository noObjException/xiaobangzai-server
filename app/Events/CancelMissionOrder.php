<?php

namespace App\Events;

use App\Models\MissionExpress;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CancelMissionOrder
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var MissionExpress
     */
    public $missionExpress;

    /**
     * Create a new event instance.
     *
     * @param MissionExpress $missionExpress
     */
    public function __construct(MissionExpress $missionExpress)
    {
        $this->missionExpress = $missionExpress;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
