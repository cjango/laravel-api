<?php

return [
    /**
     * 重新登录后，自动作废以前的token
     */
    'token_auto_revoke'             => env('TOKEN_AUTO_REVOKE', true),
    /**
     * TOKEN 过期时间，这个不确定是啥，单位 分钟
     */
    'tokens_expire_time'            => env('TOKENS_EXPIRE_TIME', 0),
    /**
     * 可用的刷新时间，单位 分钟
     */
    'refresh_tokens_expire'         => env('REFRESH_TOKENS_EXPIRE', 0),
    /**
     * 个人TOKEN过期时间，单位 分钟
     */
    'personal_access_tokens_expire' => env('PERSONAL_ACCESS_TOKENS_EXPIRE', 0),
    /**
     * token的名称
     */
    'passport_token_name'           => env('PASSPORT_TOKEN_NAME', null),

    /**
     * 作用域的配置
     */
    'scopes'                        => [],
    /**
     * 默认作用域
     */
    'default_scopes'                => [],

    /**
     * Passport Cache Config
     */
    'passport_cache'                => [
        'enable'     => env('PASSPORT_CACHE', true),
        // Cache key prefix
        'prefix'     => 'passport_',
        // The lifetime of token cache,
        // Unit: second
        'expires_in' => 300,
        // Cache tags
        'tags'       => [],
    ],

    'route'     => [
        /**
         * API 路由命名前缀
         */
        'as'               => 'api.',
        /**
         * 可配置 API 独立域名
         */
        'domain'           => env('API_ROUTE_DOMAIN', ''),
        /**
         * 不使用用独立域名，API 地址前缀
         */
        'prefix'           => env('API_ROUTE_PREFIX', 'api'),
        /**
         * API 控制器命名空间
         */
        'namespace'        => 'App\\Api\\Controllers',
        /**
         * 中间件
         */
        'middleware'       => ['api', 'api.accept'],
        /**
         * 身份认证的中间件
         */
        'middleware_auth'  => ['api', 'api.accept', 'token.auth'],
        /**
         * 获取token，获取不到也不报错的中间件
         */
        'middleware_guess' => ['api', 'api.accept', 'token.guess'],
    ],

    /**
     * 接口目录
     */
    'directory' => app_path('Api'),
];
