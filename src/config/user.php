<?php

return [
    'guest_user' => [
        'id'                 => env('GUEST_USER_ID'),
        'name'               => 'guest',
        'email'              => 'guest@example.com',
        'password'           => env('GUEST_USER_PASSWORD'),
        'avatar_path' => 'images/guest.png',
    ],

    'avatar_path' => [
        'default' => 'images/default.png',
        'kazumakishimoto' => 'images/kazumakishimoto.jpg',
    ],
];