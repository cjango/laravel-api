<?php

namespace Jason\Api\Middleware;

use Closure;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class TokenGuess extends BaseMiddleware
{

    public function handle($request, Closure $next)
    {
        $this->checkForToken($request);

        return $next($request);
    }

}