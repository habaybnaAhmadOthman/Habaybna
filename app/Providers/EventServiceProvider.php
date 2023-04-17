<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\TestEvent;
use App\Listeners\SendNewPostNotification;
use App\Events\NewPost;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        VerifyUser::class => [
            SendOtpCode::class,
        ],
        NewPost::class=>[
            SendNewPostNotification::class
        ],
        // PushNotification::class => [
        //     SendNotification::class,
        // ],


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(function (TestEvent $event) {
            return $event;
        });
        parent::boot();

        //
    }
}
