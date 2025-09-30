<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Error Reporting
    |--------------------------------------------------------------------------
    |
    | By default, Laravel will log all errors and exceptions to the log file.
    | You may customize this behavior by setting the error reporting level.
    |
    */

    'reporting' => [
        'level' => env('ERROR_REPORTING_LEVEL', E_ALL),
        'display' => env('ERROR_DISPLAY', false),
        'log' => env('ERROR_LOG', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Pages
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom error pages for different HTTP status codes.
    | These pages will be used when an error occurs in your application.
    |
    */

    'pages' => [
        404 => 'errors.404',
        500 => 'errors.500',
        503 => 'errors.503',
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Handlers
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom error handlers for different types of errors.
    | These handlers will be called when an error occurs in your application.
    |
    */

    'handlers' => [
        'exception' => App\Exceptions\Handler::class,
        'http' => App\Exceptions\HttpExceptionHandler::class,
    ],

];






