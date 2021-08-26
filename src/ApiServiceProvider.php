<?php

namespace Jason\Api;

use Illuminate\Foundation\Application;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Jason\Api\Listeners\PruneOldTokens;
use Jason\Api\Listeners\RevokeOldTokens;
use Laravel\Passport\Passport;

class ApiServiceProvider extends ServiceProvider
{

    /**
     * 命令操作
     * @var array
     */
    protected array $commands = [
        Console\ApiCommand::class,
    ];

    /**
     * 路由中间件
     * @var array
     */
    protected array $routeMiddleware = [
        'api.accept'  => Middleware\AcceptHeader::class,
        'token.auth'  => Middleware\Authorized::class,
        'token.guess' => Middleware\Guess::class,
    ];

    /**
     * Notes: 部署
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:21 下午
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config' => config_path()], 'api-config');
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/api.php', 'api');

        if (file_exists($bootstrap = $this->getBootstrapFile())) {
            require $bootstrap;
        }

        // 修改默认看守器的配置
        $this->app['config']->set('auth.guards.api', [
            'driver'   => 'passport',
            'provider' => 'users',
        ]);
        // Passport 的缓存配置
        if ($this->app['config']->get('api.passport_cache.enable')) {
            $this->app['config']->set('passport.cache', $this->app['config']->get('api.cache'));
        }

        $this->setupTokenExpireTime();
        $this->registerTokenScopes();
        $this->registerTokenListeners();

        if (file_exists($routes = $this->getRouteFile())) {
            Route::as(config('api.route.as'))
                 ->domain(config('api.route.domain'))
                 ->middleware(config('api.route.middleware'))
                 ->namespace(config('api.route.namespace'))
                 ->prefix(config('api.route.prefix'))
                 ->group($routes);
        }
    }

    /**
     * Notes   : 设置令牌的过期时间
     * @Date   : 2021/7/23 1:47 下午
     * @Author : <Jason.C>
     */
    protected function setupTokenExpireTime(): void
    {
        if ($this->app['config']->get('api.tokens_expire_time')) {
            Passport::tokensExpireIn(Carbon::now()->addMinutes($this->app['config']->get('api.tokens_expire_time')));
        }

        if ($this->app['config']->get('api.refresh_tokens_expire')) {
            Passport::refreshTokensExpireIn(Carbon::now()
                                                  ->addMinutes($this->app['config']->get('api.refresh_tokens_expire')));
        }

        if ($this->app['config']->get('api.personal_access_tokens_expire')) {
            Passport::personalAccessTokensExpireIn(Carbon::now()
                                                         ->addMinutes($this->app['config']->get('api.personal_access_tokens_expire')));
        }
    }

    /**
     * Notes   : 注册令牌作用域
     * @Date   : 2021/7/23 1:48 下午
     * @Author : <Jason.C>
     */
    protected function registerTokenScopes(): void
    {
        Passport::tokensCan($this->app['config']->get('api.scopes'));
        Passport::setDefaultScope($this->app['config']->get('api.default_scopes'));
    }

    /**
     * Notes   : 注册监听器
     * @Date   : 2021/7/23 1:49 下午
     * @Author : <Jason.C>
     */
    protected function registerTokenListeners(): void
    {
        $this->app['events']->listen('Laravel\Passport\Events\AccessTokenCreated', RevokeOldTokens::class);
        $this->app['events']->listen('Laravel\Passport\Events\RefreshTokenCreated', PruneOldTokens::class);
    }

    /**
     * Notes: 注册功能
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:21 下午
     */
    public function register()
    {
        $this->commands($this->commands);

        $this->registerRouteMiddlewares();

        $this->app->singleton('api', fn(Application $app) => new Factory($app));
    }

    /**
     * Notes: 注册路由中间件
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:21 下午
     */
    public function registerRouteMiddlewares()
    {
        foreach ($this->routeMiddleware as $key => $middleware) {
            Route::aliasMiddleware($key, $middleware);
        }
    }

    /**
     * Notes: 获取路由文件
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:21 下午
     * @return string
     */
    protected function getRouteFile(): string
    {
        return ucfirst(config('api.directory')) . DIRECTORY_SEPARATOR . 'routes.php';
    }

    /**
     * Notes: 加载部署文件
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:21 下午
     * @return string
     */
    protected function getBootstrapFile(): string
    {
        return ucfirst(config('api.directory')) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    }

    public function provides(): array
    {
        return ['api'];
    }

}
