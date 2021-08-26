<?php

namespace Jason\Api\Console;

use Illuminate\Console\Command;

class ApiCommand extends Command
{

    protected        $signature   = 'api:install';

    protected        $description = 'Install the API package';

    protected string $directory   = '';

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
        $this->call('migrate');
        $this->call('passport:install');
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
    }

    /**
     * Notes   : 创建基础控制器
     * @Date   : 2021/8/25 4:37 下午
     * @Author : <Jason.C>
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
     * Notes   : 创建默认控制器
     * @Date   : 2021/8/25 4:37 下午
     * @Author : <Jason.C>
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
     * Notes   : 创建部署文件
     * @Date   : 2021/8/25 4:37 下午
     * @Author : <Jason.C>
     */
    protected function createBootstrapFile()
    {
        $file = $this->directory . '/bootstrap.php';

        $contents = $this->getStub('bootstrap');
        $this->laravel['files']->put($file, $contents);
        $this->line('<info>Bootstrap file was created:</info> ' . str_replace(base_path(), '', $file));
    }

    /**
     * Notes   : 创建路由文件
     * @Date   : 2021/8/25 4:37 下午
     * @Author : <Jason.C>
     */
    protected function createRoutesFile()
    {
        $file = $this->directory . '/routes.php';

        $contents = $this->getStub('routes');
        $this->laravel['files']->put($file, $contents);
        $this->line('<info>Routes file was created:</info> ' . str_replace(base_path(), '', $file));
    }

    /**
     * Notes   : 获取模板内容
     * @Date   : 2021/8/25 4:37 下午
     * @Author : <Jason.C>
     * @param $name
     * @return string
     */
    protected function getStub($name): string
    {
        return $this->laravel['files']->get(__DIR__ . "/stubs/$name.stub");
    }

    /**
     * Notes   : 创建文件夹
     * @Date   : 2021/8/25 4:37 下午
     * @Author : <Jason.C>
     * @param  string  $path
     */
    protected function makeDir(string $path = '')
    {
        $this->laravel['files']->makeDirectory("{$this->directory}/$path", 0755, true, true);
    }

}
