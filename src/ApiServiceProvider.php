<?php

namespace Jason\Api;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * 命令操作.
     *
     * @var array
     */
    protected array $commands = [
        Console\ApiCommand::class,
    ];

    /**
     * 路由中间件.
     *
     * @var array
     */
    protected array $routeMiddleware = [
        'api.accept'  => Middleware\AcceptHeader::class,
        'token.auth'  => Middleware\Authorized::class,
        'token.guess' => Middleware\Guess::class,
    ];

    /**
     * Notes: 部署.
     *
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:21 下午
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'api-config');
        }

        $this->mergeConfigFrom(__DIR__.'/../config/api.php', 'api');

        if (file_exists($bootstrap = $this->getBootstrapFile())) {
            require $bootstrap;
        }

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
     * Notes: 注册功能.
     *
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:21 下午
     */
    public function register()
    {
        $this->commands($this->commands);

        $this->registerRouteMiddlewares();

        $this->app->singleton('api', fn (Application $app) => new Factory($app));
    }

    /**
     * Notes: 注册路由中间件.
     *
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
     * Notes: 获取路由文件.
     *
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:21 下午
     *
     * @return string
     */
    protected function getRouteFile(): string
    {
        return ucfirst(config('api.directory')).DIRECTORY_SEPARATOR.'routes.php';
    }

    /**
     * Notes: 加载部署文件.
     *
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:21 下午
     *
     * @return string
     */
    protected function getBootstrapFile(): string
    {
        return ucfirst(config('api.directory')).DIRECTORY_SEPARATOR.'bootstrap.php';
    }

    public function provides(): array
    {
        return ['api'];
    }
}
