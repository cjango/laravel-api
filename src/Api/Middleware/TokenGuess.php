<?php

namespace Jason\Api\Middleware;

use Closure;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class TokenGuess extends BaseMiddleware
{

    public function handle($request, Closure $next)
    {
        try {
            $this->checkForToken($request);
        } catch (\Exception $exception) {
        }

        return $next($request);
    }

}
