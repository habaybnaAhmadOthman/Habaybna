<?php
return [
    // sts keys
    'stssecret' => env('STS_SECRET', 'Laravel'),
    'stsmerchantid' => env('STS_Merchant_ID', 'Laravel'),
    'stsredirecturl' => env('REDIRECT_URL', 'Laravel'),

    // releans keys
    'releanssecret' => env('RELEANS_SECRET', 'Laravel'),

    // mailerlight keys
    'mailerliteapikey' => env('MAILERLITE_APIKEY', 'Laravel'),
    'mailerlitelistid' => env('MAILERLITE_LIST_ID', 'Laravel'),
];
