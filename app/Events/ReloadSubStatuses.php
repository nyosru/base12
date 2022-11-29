<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReloadSubStatuses implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $root_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($root_id)
    {
        $this->root_id=$root_id;
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
        return 'reload-sub-statuses';
    }

}
