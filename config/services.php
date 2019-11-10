<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'google' => [
        'analytics' => env('GOOGLE_ANALYTICS', FALSE)
    ],

    'disqus' => [
        'shortname' => env('DISQUS_SHORTNAME', FALSE),
        'publickey' => env('DISQUS_PUBLICKEY', FALSE)
    ]

];