<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReloadSubStatusTms implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $substatus_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($substatus_id)
    {
        $this->substatus_id=$substatus_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('queue-script-channel');
    }

    public function broadcastAs()
    {
        return 'reload-sub-status-tms';
    }

}
