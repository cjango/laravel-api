<?php

namespace Jason\Api;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{

    /**
     * 命令操作
     * @var array
     */
    protected $commands = [
        Console\ApiCommand::class,
    ];

    /**
     * 路由中间件
     * @var array
     */
    protected $routeMiddleware = [
        'token.auth'   => Middleware\TokenAuthRefresh::class,
        'client.check' => Middleware\ClientCheck::class,
    ];

    /**
     * Notes: 部署
     * @Author: <C.Jason>
     * @Date: 2020/1/14 5:21 下午
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config' => config_path()], 'api-config');
        }

        if (file_exists($bootstrap = $this->getBootstrapFile())) {
            require $bootstrap;
        }

        if (file_exists($routes = $this->getRouteFile())) {
            $this->loadRoutesFrom($routes);
        }
    }

    /**
     * Notes: 注册功能
     * @Author: <C.Jason>
     * @Date: 2020/1/14 5:21 下午
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/api.php', 'api');

        config(['auth.guards.api' => config('api.guard')]);
        $this->commands($this->commands);

        $this->registerRouteMiddlewares();
    }

    /**
     * Notes: 注册路由中间件
     * @Author: <C.Jason>
     * @Date: 2020/1/14 5:21 下午
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
     * @Date: 2020/1/14 5:21 下午
     * @return string
     */
    protected function getRouteFile()
    {
        return ucfirst(config('api.directory')) . DIRECTORY_SEPARATOR . 'routes.php';
    }

    /**
     * Notes: 加载部署文件
     * @Author: <C.Jason>
     * @Date: 2020/1/14 5:21 下午
     * @return string
     */
    protected function getBootstrapFile()
    {
        return ucfirst(config('api.directory')) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    }

}
