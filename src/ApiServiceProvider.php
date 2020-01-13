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
     * 部署
     * @Author:<C.Jason>
     * @Date:2019-07-30T08:59:16+0800
     * @return void
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
     * 注册功能
     * @Author:<C.Jason>
     * @Date:2019-07-30T08:59:28+0800
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/api.php', 'api');

        $this->commands($this->commands);

        $this->registerRouteMiddlewares();
    }

    /**
     * 注册路由中间件
     * @Author:<C.Jason>
     * @Date:2019-07-30T08:59:40+0800
     * @return void
     */
    public function registerRouteMiddlewares()
    {
        foreach ($this->routeMiddleware as $key => $middleware) {
            Route::aliasMiddleware($key, $middleware);
        }
    }

    /**
     * 获取路由文件
     * @Author:<C.Jason>
     * @Date:2019-07-29T14:59:53+0800
     * @return string 路由文件地址
     */
    protected function getRouteFile()
    {
        return ucfirst(config('api.directory')) . DIRECTORY_SEPARATOR . 'routes.php';
    }

    /**
     * 加载部署文件
     * @Author:<C.Jason>
     * @Date:2019-07-29T16:41:23+0800
     * @return string 部署文件地址
     */
    protected function getBootstrapFile()
    {
        return ucfirst(config('api.directory')) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    }
}
