<?php

namespace Jason\Api;

use Illuminate\Support\Facades\Auth;

class Api
{

    /**
     * API 认证的看守
     * @var string
     */
    const GUARD = 'api';

    /**
     * Notes: 获取当前认证用户
     * @Author: <C.Jason>
     * @Date: 2020/1/15 1:48 下午
     * @return mixed
     */
    public function user()
    {
        return Auth::guard(self::GUARD)->user();
    }

    /**
     * Notes: 获取当前认证用户ID
     * @Author: <C.Jason>
     * @Date: 2020/1/15 1:48 下午
     * @return mixed
     */
    public function id()
    {
        return Auth::guard(self::GUARD)->id();
    }

    /**
     * Notes: 认证用户
     * @Author: <C.Jason>
     * @Date: 2020/1/15 1:51 下午
     * @param array $credentials
     * @return mixed
     */
    public function attempt(array $credentials)
    {
        return Auth::guard(self::GUARD)->attempt($credentials);
    }

    /**
     * Notes: 认证用户
     * @Author: <C.Jason>
     * @Date: 2020/1/15 1:51 下午
     * @param $user
     * @return mixed
     */
    public function login($user)
    {
        return Auth::guard(self::GUARD)->login($user);
    }

}
