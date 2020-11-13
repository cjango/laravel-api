<?php

namespace Jason\Api\Middleware;

use Auth;
use Closure;
use Exception;
use Jason\Api\Api;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class TokenGuess extends BaseMiddleware
{

    public function handle($request, Closure $next)
    {
        try {
            $this->checkForToken($request);
            $this->auth->parseToken()->authenticate();
        } catch (TokenExpiredException $exception) {
            $token = $this->auth->refresh();
            Auth::guard(Api::GUARD)->onceUsingId(
                $this->auth
                    ->manager()
                    ->getPayloadFactory()
                    ->buildClaimsCollection()
                    ->toPlainArray()['sub']
            );

            return $this->setAuthenticationHeader($next($request), $token);
        } catch (Exception $exception) {
            return $next($request);
        }

        return $next($request);
    }

}
