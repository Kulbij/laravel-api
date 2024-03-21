<?php

return [
    'mode' => env('GETTY_IMAGES_MODE', 'test'),
    
    'auth_url' => env('DATAFORSEO_AUTH_URL', 'https://api.gettyimages.com/oauth2/token'),

    'live' => [
        'url' => env('DATAFORSEO_LIVE_URL'),

        'key' => env('DATAFORSEO_LIVE_KEY'),
        'secret' => env('DATAFORSEO_LIVE_SECRET'),

        'login' => env('DATAFORSEO_LIVE_LOGIN'),
        'password' => env('DATAFORSEO_LIVE_PASSWORD'),
    ],

    'test' => [
        'url' => env('DATAFORSEO_TEST_URL'),

        'key' => env('DATAFORSEO_TEST_KEY'),
        'secret' => env('DATAFORSEO_TEST_SECRET'),

        'login' => env('DATAFORSEO_TEST_LOGIN'),
        'password' => env('DATAFORSEO_TEST_PASSWORD'),
    ],
];
