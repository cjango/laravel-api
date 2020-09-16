<?php

namespace Jason\Api\Middleware;

use Auth;
use Closure;
use Jason\Api\Api;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class TokenAuthRefresh extends BaseMiddleware
{

    /**
     * Notes: token 认证中间件，实现了token的自动刷新续期
     * @Author: <C.Jason>
     * @Date  : 2020/6/19 10:36 上午
     * @param          $request
     * @param \Closure $next
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|mixed
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function handle($request, Closure $next)
    {
        $this->checkForToken($request);

        try {
            if ($this->auth->parseToken()->authenticate()) {
                return $next($request);
            }
            throw new UnauthorizedHttpException('jwt-auth', '未登录');
        } catch (TokenBlacklistedException $exception) {
            throw new UnauthorizedHttpException('jwt-auth', '未登录');
        } catch (TokenExpiredException $exception) {
            try {
                $token = $this->auth->refresh();
                Auth::guard(Api::GUARD)->onceUsingId(
                    $this->auth
                        ->manager()
                        ->getPayloadFactory()
                        ->buildClaimsCollection()
                        ->toPlainArray()['sub']
                );
            } catch (JWTException $exception) {
                throw new UnauthorizedHttpException('jwt-auth', $exception->getMessage());
            }
        }

        return $this->setAuthenticationHeader($next($request), $token);
    }

}
