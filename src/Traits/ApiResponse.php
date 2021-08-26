<?php

namespace Jason\Api\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

trait ApiResponse
{

    /**
     * 状态码
     * @var int
     */
    protected int $statusCode = FoundationResponse::HTTP_OK;

    /**
     * Notes: 设置状态码
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:16 下午
     * @param  int  $statusCode
     * @return \Jason\Api\Traits\ApiResponse
     */
    protected function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Notes: 成功的返回
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:16 下午
     * @param  mixed   $data
     * @param  string  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data = [], string $status = "SUCCESS"): JsonResponse
    {
        return $this->status($status, compact('data'));
    }

    /**
     * Notes: 返回消息
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:16 下午
     * @param  string  $message
     * @param  string  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function message(string $message = '', string $status = "SUCCESS"): JsonResponse
    {
        return $this->status($status, [
            'message' => $message,
        ]);
    }

    /**
     * Notes: 失败
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:16 下午
     * @param  string  $message
     * @param  int     $code
     * @param  string  $status
     * @return mixed
     */
    public function failed(
        string $message = '',
        int $code = FoundationResponse::HTTP_BAD_REQUEST,
        string $status = 'ERROR'
    ) {
        return $this->setStatusCode($code)->message($message, $status);
    }

    /**
     * Notes:
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:17 下午
     * @param  string    $status
     * @param  array     $data
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function status(string $status, array $data, int $code = null): JsonResponse
    {
        if ($code) {
            $this->setStatusCode($code);
        }

        $status = [
            'status'      => $status,
            'status_code' => $this->statusCode,
        ];

        $data = array_merge($status, $data);

        return $this->respond($data);
    }

    /**
     * Notes: 结果返回
     * @Author: <C.Jason>
     * @Date  : 2020/1/14 5:17 下午
     * @param  mixed  $data
     * @param  array  $header
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data, array $header = []): JsonResponse
    {
        return Response::json($data, 200, $header);
    }

}
