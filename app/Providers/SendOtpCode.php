<?php

namespace App\Providers;

use App\Providers\VerifyUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\CustomClass\SendSms;


class SendOtpCode
{
    public $sendSms ;
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
     * @param  VerifyUser  $event
     * @return void
     */
    public function handle(VerifyUser $event)
    {
        \App\CustomClass\SendSms::execute($event->phone,$event->otp);
    }
}
