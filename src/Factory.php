<?php

namespace Jason\Api;

use Illuminate\Foundation\Application;

class Factory
{

    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Notes   : 当前登录用户
     * @Date   : 2021/7/21 5:30 下午
     * @Author : < Jason.C >
     * @return mixed
     */
    public function user()
    {
        return $this->app['auth']->user();
    }

    /**
     * Notes   : 当前登录用户ID
     * @Date   : 2021/7/21 5:31 下午
     * @Author : < Jason.C >
     * @return mixed
     */
    public function userId()
    {
        return $this->app['auth']->id();
    }

    /**
     * Notes   : 检测用户是否已登录
     * @Date   : 2021/8/9 4:01 下午
     * @Author : < Jason.C >
     * @return mixed
     */
    public function check()
    {
        return $this->app['auth']->check();
    }

    /**
     * Notes   : 检测是否游客登录
     * @Date   : 2021/8/9 4:02 下午
     * @Author : < Jason.C >
     * @return mixed
     */
    public function guest()
    {
        return $this->app['auth']->guest();
    }

}