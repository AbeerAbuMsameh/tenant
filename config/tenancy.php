<?php

return [
    'default_database' => [
        'driver'    => env('DB_CONNECTION', 'mysql'),
        'host'      => env('DB_HOST', 'localhost'),
        'port'      => env('DB_PORT', 3306),
        'username'  => env('DB_USERNAME', 'root'),
        'password'  => env('DB_PASSWORD', ''),
    ],
    'default_server' => [
        'domain'    => env('SERVER_NAME', 'localhost'),
        'ip'        => env('SERVER_IP', '127.0.0.1'),
    ],
];
