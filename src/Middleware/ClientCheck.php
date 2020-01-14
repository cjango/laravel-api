<?php

namespace Jason\Api\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class ClientCheck extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $payload = $this->auth->payload()->jsonSerialize();
        $user    = $this->auth->user();

        if ($payload['ip'] != $user->last_ip || $payload['iat'] != $user->last_time) {
            throw new TokenExpiredException("该账户已在其他设备登陆");
        }

        return $next($request);
    }

}
