<?php

namespace Jason\Api\Middleware;

use Closure;
use Illuminate\Http\Request;

class AcceptHeader
{

    /**
     * Notes   :
     * @Date   : 2021/6/9 9:30 上午
     * @Author : < Jason.C >
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }

}