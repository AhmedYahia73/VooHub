<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UsersEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_count;
    public $user_stauts;
    public $user_id;
    /**
     * Create a new event instance.
     */
    public function __construct(
        $user_count, $user_stauts, $user_id,
        $event_id){
        $this->user_count = $user_count;
        $this->user_stauts = $user_stauts;
        $this->user_id = $user_id;
        $this->event_id = $event_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('user_event'),
        ];
    }

    public function broadcastWith(){
        return [
            'users_count' => $this->user_count,
            'user_stauts' => $this->user_stauts,
            'user_id' => $this->user_id,
            'event_id' => $this->event_id,
        ];
    }
}
