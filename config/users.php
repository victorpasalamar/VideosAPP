<?php

return [
    'default_user' => [
        'name' => env('DEFAULT_USER_NAME', 'Default User'),
        'email' => env('DEFAULT_USER_EMAIL', 'default@user.com'),
        'password' => env('DEFAULT_USER_PASSWORD', 'password'),
    ],
    'professor' => [
        'name' => env('DEFAULT_USER_NAME','Professor User'),
        'email' => env('DEFAULT_USER_EMAIL','professor@professor.com'),
        'password' => env('DEFAULT_USER_PASSWORD','password'),
    ],
];
