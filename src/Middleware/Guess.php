<?php

namespace Jason\Api\Middleware;

use Illuminate\Auth\Middleware\Authenticate;

class Guess extends Authenticate
{
    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard('sanctum')->check()) {
            return $this->auth->shouldUse('sanctum');
        }
    }
}
