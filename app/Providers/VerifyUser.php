<?php

namespace App\Providers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VerifyUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
        public $phone ;
        public $otp ;
        public $msg ;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($phone, $otp,$msg=null)
    {
        $this->phone = $phone ;
        $this->otp = $otp ;
        $this->msg = $msg ;
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
