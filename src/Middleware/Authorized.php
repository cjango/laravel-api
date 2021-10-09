<?php

namespace Jason\Api\Middleware;

use Illuminate\Auth\Middleware\Authenticate;
use Jason\Api\Exceptions\UnauthorizedException;

class Authorized extends Authenticate
{
    /**
     * @throws UnauthorizedException
     */
    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard('sanctum')->check()) {
            return $this->auth->shouldUse('sanctum');
        }

        throw new UnauthorizedException();
    }
}
