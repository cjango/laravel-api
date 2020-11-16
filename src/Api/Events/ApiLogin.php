<?php

namespace Jason\Api\Events;

use Illuminate\Foundation\Events\Dispatchable;

class ApiLogin
{

    use Dispatchable;

    public $user;

    /**
     * 创建一个事件实例
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

}