<?php

return [
    /**
     * 认证看守，使用JWT驱动
     */
    'guard' => [
        'driver'   => 'jwt',
        'provider' => 'users',
        'hash'     => false,
    ],

    'route'     => [
        /**
         * 可配置接口独立域名
         */
        'domain'          => env('API_ROUTE_DOMAIN', ''),
        /**
         * 不实用独立域名，接口地址前缀
         */
        'prefix'          => env('API_ROUTE_PREFIX', 'api'),
        /**
         * 接口控制器命名空间
         */
        'namespace'       => 'App\\Api\\Controllers',
        /**
         * 中间件
         */
        'middleware'      => ['api'],
        /**
         * 身份认证的中间件
         */
        'middleware_auth' => ['api', 'token.auth'],
        /**
         * 获取token，获取不到也不报错的中间件
         */
        'middleware_guess' => ['api', 'token.guess'],
    ],

    /**
     * 接口目录
     */
    'directory' => app_path('Api'),
];
