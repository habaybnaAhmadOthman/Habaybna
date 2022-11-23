<?php
// use Spatie\Newsletter\Newsletter;
use Newsletter;
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
