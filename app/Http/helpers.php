<?php
// use Spatie\Newsletter\Newsletter;
use Newsletter;
use MailerLiteApi\MailerLite;

if (! function_exists('mailChimpSubscribe')) {
    function mailChimpSubscribe($data)
    {
        Newsletter::subscribe(
            $data['email'],
            [
                'FNAME'=>$data['firstName'],
                'LNAME'=>$data['firstName']
            ]
        );

        // Add tags to subscriber
        Newsletter::addTags(['new user',$data['type']], $data['email']);
    }
}

if (! function_exists('mailerLiteSubscribe')) {


    function mailerLiteSubscribe($data)
    {
        $mailerlite_group_api = ( new \MailerLiteApi\MailerLite( env('MAILERLITE_APIKEY') ) )->groups();
        // dd($mailerlite_group_api->get());
        $mailerlite_subscriber = [
            'email'  => $data['email'],
            'fields' => [
                'name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'role' => $data['type'],
                'tage' => $data['tag'],
                'phone' => $data['phone'],
            ],
        ];

        $response = $mailerlite_group_api->addSubscriber( '74288482240955423', $mailerlite_subscriber ); // habaybna subscribers

        if($data && $data['type']=='parent') {

            $response = $mailerlite_group_api->addSubscriber( '74378202401735948', $mailerlite_subscriber ); // parent subscribers
        }
        if($data && $data['type']=='specialist') {

            $response = $mailerlite_group_api->addSubscriber( '74378232790517589', $mailerlite_subscriber ); // specialist subscribers
        }
        if($data && $data['type']=='other') {

            $response = $mailerlite_group_api->addSubscriber( '74378252846630174', $mailerlite_subscriber ); // other subscribers
        }



    }
}
