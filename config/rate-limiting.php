<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Here you may configure the rate limiting for your application. You can
    | set different rate limits for different types of requests.
    |
    */

    'default' => [
        'max_attempts' => 60,
        'decay_minutes' => 1,
    ],

    'login' => [
        'max_attempts' => 5,
        'decay_minutes' => 1,
    ],

    'api' => [
        'max_attempts' => 60,
        'decay_minutes' => 1,
    ],

    'password_reset' => [
        'max_attempts' => 3,
        'decay_minutes' => 1,
    ],

];