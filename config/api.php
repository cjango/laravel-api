<?php

return [
    /**
     * 重新登录后，自动作废以前的token.
     */
    'token_auto_revoke'   => env('TOKEN_AUTO_REVOKE', true),
    /**
     * token的名称.
     */
    'passport_token_name' => env('PASSPORT_TOKEN_NAME', ''),

    'route'     => [
        /**
         * API 路由命名前缀
         */
        'as'               => 'api.',
        /**
         * 可配置 API 独立域名.
         */
        'domain'           => env('API_ROUTE_DOMAIN', ''),
        /**
         * 不使用用独立域名，API 地址前缀
         */
        'prefix'           => env('API_ROUTE_PREFIX', 'api'),
        /**
         * API 控制器命名空间.
         */
        'namespace'        => 'App\\Api\\Controllers',
        /**
         * 中间件.
         */
        'middleware'       => ['api', 'api.accept'],
        /**
         * 身份认证的中间件.
         */
        'middleware_auth'  => ['api', 'api.accept', 'token.auth'],
        /**
         * 获取token，获取不到也不报错的中间件.
         */
        'middleware_guess' => ['api', 'api.accept', 'token.guess'],
    ],

    /**
     * 接口目录.
     */
    'directory' => app_path('Api'),
];
