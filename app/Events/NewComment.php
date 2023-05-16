<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewComment implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $post_id ;
    public $user_id ;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($post_id, $user_id)
    {
        $this->post_id = $post_id ;
        $this->user_id = $user_id ;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('usernewcomment');
    }

    public function broadcastWith()
    {
        return ['usernewcomment'=> $this->user_id];
    }

}
