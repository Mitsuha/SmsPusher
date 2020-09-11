<?php

return[
    'table-name' => 'smsVerificationCode',

    'route-prefix' => '/api/sms/captcha',

    'valid' => 5,

    'inputKey' => 'telephone',

    'reuse' => true,

    'success-response' => [
        'code' => 200,
        'message' => 'SMS verification code sent successfully'
    ],

    'content' => 'Your SMS verification code is {code}, valid within {valid} minutes',

    'driver' => [
        'default' => 'redis',
        'implement' => [
            'redis' => \mitsuha\SmsPusher\Driver\RedisDriver::class,
            'hash' => \mitsuha\SmsPusher\Driver\HashDriver::class,
        ]
    ],

    'pusher' => [
        'default' => 'smsBao',
        'implement' => [
            'faker' => \mitsuha\SmsPusher\Sms\FakerPusher::class,
            'smsBao' => \mitsuha\SmsPusher\Sms\SmsBaoPusher::class
        ]
    ],

    'pusher-configuration' => [
        'faker' => null,
        'smsBao' => [
            'username' => env('SMS_BAO_USERNAME'),
            'password' => env('SMS_BAO_PASSWORD')
        ]
    ],

    'driver-configuration' => [
        'redis' => [
            //
        ]
    ]
];
