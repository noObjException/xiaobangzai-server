<?php

namespace App\Events;

use App\Models\Members;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChangedCredit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $members;

    public $action;

    public $value;

    /**
     * Create a new event instance.
     *
     * @param Members $members
     * @param string $action 对积分改变的操作描述
     * @param int $value 改变的值
     */
    public function __construct(Members $members, $action = '', $value = 0)
    {
        $this->members = $members;
        $this->action  = $action;
        $this->value   = $value;
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
