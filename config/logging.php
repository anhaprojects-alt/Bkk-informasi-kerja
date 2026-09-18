<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that is used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stderr'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Laravel
    | images utilize the Monolog PHP logging library, which includes a
    | variety of powerful log handlers and utilities for you to use.
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['stderr'],
            'ignore_exceptions' => false,
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => Monolog\Handler\StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
            'processors' => [App\Logging\LogProcessor::class],
        ],
    ],

];
