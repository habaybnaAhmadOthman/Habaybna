<?php

namespace App\Listeners;

use App\Events\NewPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Specialist;
use App\User;
// use Illuminate\Notifications\Notification;
use App\Notifications\NewPostNotification;
use Illuminate\Support\Facades\Notification;

class SendNewPostNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewPost  $event
     * @return void
     */
    public function handle(NewPost $event)
    {
        // $data = Specialist::where('can_make_comments', true)->get();
        $data = User::whereHas('specialist',function($query){
            $query->where('can_make_comments', true);

        })->get();

        // \Illuminate\Support\Facades\Notification::sen
        // foreach($data as $one ) {

            Notification::send($data, new NewPostNotification());
        // }


    }

}
