<?php

namespace Jason\Api\Traits;

use Illuminate\Http\JsonResponse;
use Throwable;

trait ApiException
{

    protected function prepareJsonResponse($request, Throwable $e)
    {
        return new JsonResponse([
            'status'      => 'EXCEPTION',
            'status_code' => $this->getErrorCode($e),
            'message'     => $e->getMessage(),
            'exception'   => get_class($e),
            'api_uri'     => $request->url(),
        ]);
    }

    /**
     * Notes: 有些错误没有 getStatusCode 的问题
     * @Author: <C.Jason>
     * @Date  : 2020/6/17 2:11 下午
     * @param \Throwable $e
     * @return int
     */
    protected function getErrorCode(Throwable $e)
    {
        try {
            return $e->getStatusCode();
        } catch (Throwable $exception) {
            return $e->getCode();
        }
    }

}
