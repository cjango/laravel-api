<?php

namespace Jason\Api\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

trait ApiException
{

    /**
     * Notes: 表单验证错误信息
     * @Author: <C.Jason>
     * @Date  : 2020/11/10 11:21 上午
     * @param                                            $request
     * @param \Illuminate\Validation\ValidationException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'status'      => 'ERROR',
            'status_code' => 422,
            'message'     => $exception->errors()->first(),
        ]);
    }

    /**
     * Notes: 统一错误信息格式
     * @Author: <C.Jason>
     * @Date  : 2020/11/10 11:21 上午
     * @param            $request
     * @param \Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function prepareJsonResponse($request, Throwable $e)
    {
        $message = [
            'status'      => 'EXCEPTION',
            'status_code' => $this->getErrorCode($e),
            'message'     => $e->getMessage(),
        ];

        if (config('app.debug')) {
            $message = array_merge($message, [
                'exception' => get_class($e),
                'api_uri'   => $request->url(),
            ]);
        }

        return new JsonResponse($message);
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
