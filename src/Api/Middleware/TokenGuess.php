<?php

namespace Jason\Api\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class TokenGuess extends BaseMiddleware
{

    public function handle($request, Closure $next)
    {
        try {
            $this->checkForToken($request);
            $this->auth->parseToken()->authenticate();
        } catch (Exception $exception) {

        }

        return $next($request);
    }

}
