<?php

return [

    'guard' => [
        'driver'   => 'jwt',
        'provider' => 'users',
        'hash'     => false,
    ],

    'route' => [

        'domain' => env('API_ROUTE_DOMAIN', ''),

        'prefix' => env('API_ROUTE_PREFIX', 'api'),

        'namespace' => 'App\\Api\\Controllers',

        'middleware' => ['web', 'api'],
    ],

    'directory' => app_path('Api'),
];
