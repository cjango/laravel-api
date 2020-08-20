<?php

namespace Jason\Api\Console;

use Illuminate\Console\Command;

class ApiCommand extends Command
{

    protected $signature = 'api:install';

    protected $description = 'Install the API package';

    protected $directory = '';

    public function handle()
    {
        $this->publishConfig();
        $this->initDirectory();
    }

    protected function publishConfig()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Jason\Api\ApiServiceProvider',
        ]);
    }

    protected function initDirectory()
    {
        $this->directory = config('api.directory');

        if (is_dir($this->directory)) {
            $this->line("<error>{$this->directory} directory already exists !</error> ");
            return;
        }

        $this->makeDir('/');
        $this->line('<info>Api directory was created:</info> ' . str_replace(base_path(), '', $this->directory));

        $this->makeDir('Resources');
        $this->line('<info>Resources directory was created:</info> ' . str_replace(base_path(), '', $this->directory));

        $this->makeDir('Controllers');

        $this->createBaseController();

        $this->createIndexController();

        $this->createBootstrapFile();

        $this->createRoutesFile();

        $this->publishJWTconfig();

    }

    /**
     * 创建基础控制器
     * @Author:<C.Jason>
     * @Date  :2019-07-29T16:18:22+0800
     * @return void
     */
    protected function createBaseController()
    {
        $baseController = $this->directory . '/Controllers/Controller.php';
        $contents       = $this->getStub('Controller');

        $this->laravel['files']->put(
            $baseController,
            str_replace('DummyNamespace', config('api.route.namespace'), $contents)
        );
        $this->line('<info>BaseController file was created:</info> ' . str_replace(base_path(), '', $baseController));
    }

    /**
     * 创建默认控制器
     * @Author:<C.Jason>
     * @Date:2019-07-29T16:18:49+0800
     * @return void
     */
    protected function createIndexController()
    {
        $indexController = $this->directory . '/Controllers/IndexController.php';
        $contents        = $this->getStub('IndexController');

        $this->laravel['files']->put(
            $indexController,
            str_replace('DummyNamespace', config('api.route.namespace'), $contents)
        );
        $this->line('<info>IndexController file was created:</info> ' . str_replace(base_path(), '', $indexController));
    }

    /**
     * 创建部署文件
     * @Author:<C.Jason>
     * @Date:2019-07-29T16:19:06+0800
     * @return void
     */
    protected function createBootstrapFile()
    {
        $file = $this->directory . '/bootstrap.php';

        $contents = $this->getStub('bootstrap');
        $this->laravel['files']->put($file, $contents);
        $this->line('<info>Bootstrap file was created:</info> ' . str_replace(base_path(), '', $file));
    }

    /**
     * 创建路由文件
     * @Author:<C.Jason>
     * @Date:2019-07-29T16:19:24+0800
     * @return void
     */
    protected function createRoutesFile()
    {
        $file = $this->directory . '/routes.php';

        $contents = $this->getStub('routes');
        $this->laravel['files']->put($file, $contents);
        $this->line('<info>Routes file was created:</info> ' . str_replace(base_path(), '', $file));
    }

    /**
     * 发布JWT的配置文件
     * @Author:<C.Jason>
     * @Date:2019-07-29T16:17:58+0800
     * @return void
     */
    protected function publishJWTconfig()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Tymon\JWTAuth\Providers\LaravelServiceProvider',
        ]);

        $this->call('jwt:secret');
    }

    /**
     * Get stub contents.
     * @param $name
     * @return string
     */
    protected function getStub($name)
    {
        return $this->laravel['files']->get(__DIR__ . "/stubs/$name.stub");
    }

    /**
     * Make new directory.
     * @param string $path
     */
    protected function makeDir($path = '')
    {
        $this->laravel['files']->makeDirectory("{$this->directory}/$path", 0755, true, true);
    }
}
