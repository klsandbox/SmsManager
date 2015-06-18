<?php

return [

    'host' => env('SMS_HOST', 'localhost:8000'),
    'route' => env('SMS_ROUTE', 'sms-management/fake-sms'),
    'username' => env('SMS_USERNAME'),
    'password' => env('SMS_PASSWORD'),
    'sender' => env('SMS_SENDER'),
    'type' => env('SMS_TYPE', 1),
    'pretend' => false,
    'prefix' => null,
];
