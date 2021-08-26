<?php

namespace Jason\Api\Middleware;

use Illuminate\Auth\Middleware\Authenticate;
use Jason\Api\Exceptions\UnauthorizedException;

class Authorized extends Authenticate
{

    /**
     * @throws \Jason\Api\Exceptions\UnauthorizedException
     */
    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard('api')->check()) {
            return $this->auth->shouldUse('api');
        }

        throw new UnauthorizedException();
    }

}