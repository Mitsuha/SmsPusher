<?php

return[
    'table-name' => 'smsVerificationCode',

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
        'default' => 'faker',
        'implement' => [
            'faker' => \mitsuha\SmsPusher\Sms\FakerPusher::class
        ]
    ],

    'pusher-configuration' => [
        'faker' => null,
    ],

    'driver-configuration' => [
        'redis' => [
            //
        ]
    ]
];