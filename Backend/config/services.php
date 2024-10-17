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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'eduid' => [
        'client_id' => env('EDUID_CLIENT_ID'),
        'client_secret' => env('EDUID_CLIENT_SECRET'),
        'user_url' => env('EDUID_SERVER_USER_URL'),
        'token_url' => env('EDUID_SERVER_TOKEN_URL'),
        'authorize_url' => env('EDUID_SERVER_AUTHORIZE_URL'),
        'logout_url' => env('EDUID_SERVER_LOGOUT_URL'),
        'redirect' => '/oauth/callback',
    ],

];
