<?php

namespace Jason\Api\Listeners;

class LoginListener
{
    /**
     * Notes   : 登录成功后，自动删除原有的token
     *           这样大概能做到单点登录的效果.
     *
     * @Date   : 2021/8/27 9:40 上午
     * @Author : <Jason.C>
     *
     * @param $event
     */
    public function handle($event)
    {
        if (config('api.token_auto_revoke')) {
            $event->user->tokens()->delete();
        }
    }
}
