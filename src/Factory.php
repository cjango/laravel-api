<?php

namespace Jason\Api;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\User;

class Factory
{

    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Notes   : 用户认证
     * @Date   : 2021/8/26 11:26 上午
     * @Author : <Jason.C>
     * @param  array  $credentials
     * @param  array  $scopes
     * @return string
     * @throws \Exception
     */
    public function attempt(array $credentials, array $scopes = []): string
    {
        if ($this->app['auth']->attempt($credentials)) {
            $tokenName = $this->app['config']->get('api.passport_token_name');

            return $this->app['auth']->user()->createToken($tokenName, $scopes)->plainTextToken;
        } else {
            throw new \Exception('Authorize failed, wrong credentials');
        }
    }

    /**
     * Notes   : 登录一个用户
     * @Date   : 2021/8/26 11:41 上午
     * @Author : <Jason.C>
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  array                             $scopes
     * @return mixed
     */
    public function login(User $user, array $scopes = [])
    {
        $this->app['auth']->login($user);
        $tokenName = $this->app['config']->get('api.passport_token_name');

        return $this->app['auth']->user()->createToken($tokenName, $scopes)->plainTextToken;
    }

    /**
     * Notes   : 当前登录用户
     * @Date   : 2021/7/21 5:30 下午
     * @Author : <Jason.C>
     * @return User
     */
    public function user(): User
    {
        return $this->app['auth']->user();
    }

    /**
     * Notes   : 当前登录用户ID
     * @Date   : 2021/7/21 5:31 下午
     * @Author : <Jason.C>
     * @return int
     */
    public function userId(): int
    {
        return $this->app['auth']->id();
    }

    /**
     * Notes   : 检测用户是否已登录
     * @Date   : 2021/8/9 4:01 下午
     * @Author : <Jason.C>
     * @return bool
     */
    public function check(): bool
    {
        return $this->app['auth']->check();
    }

    /**
     * Notes   : 检测是否游客登录
     * @Date   : 2021/8/9 4:02 下午
     * @Author : <Jason.C>
     * @return bool
     */
    public function guest(): bool
    {
        return $this->app['auth']->guest();
    }

}