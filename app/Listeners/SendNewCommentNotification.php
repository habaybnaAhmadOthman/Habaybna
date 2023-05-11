<?php

namespace App\Listeners;

use App\Events\NewPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Specialist;
use App\User;
// use Illuminate\Notifications\Notification;
use App\Notifications\NewPostNotification;
use App\Notifications\NewCommentNotification;
use Illuminate\Support\Facades\Notification;
use App\Events\NewComment;

class SendNewCommentNotification
{
    // public $user ;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewComment  $event
     * @return void
     */
    public function handle(NewComment $event)
    {
        $data = User::whereHas('specialist',function($query){
                $query->where('can_make_comments', true);
                })->get();
                $all = collect([$data,[$event->user]])->collapse();
            Notification::send($all, new NewCommentNotification());
            // Notification::send($event, new NewCommentNotification());


    }

}
