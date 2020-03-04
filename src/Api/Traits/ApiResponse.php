<?php

namespace Jason\Api\Traits;

use Response;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

trait ApiResponse
{

    /**
     * [$statusCode description]
     * @var [type]
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * Notes: 获取状态码
     * @Author: <C.Jason>
     * @Date: 2020/1/14 5:16 下午
     * @return int
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Notes: 设置状态码
     * @Author: <C.Jason>
     * @Date: 2020/1/14 5:16 下午
     * @param $statusCode
     * @return $this
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Notes: 成功的返回
     * @Author: <C.Jason>
     * @Date: 2020/1/14 5:16 下午
     * @param $data
     * @param string $status
     * @return mixed
     */
    public function success($data, $status = "SUCCESS")
    {
        return $this->status($status, compact('data'));
    }

    /**
     * Notes: 返回消息
     * @Author: <C.Jason>
     * @Date: 2020/1/14 5:16 下午
     * @param $message
     * @param string $status
     * @return mixed
     */
    public function message($message, $status = "SUCCESS")
    {
        return $this->status($status, [
            'message' => $message,
        ]);
    }

    /**
     * Notes: 失败
     * @Author: <C.Jason>
     * @Date: 2020/1/14 5:16 下午
     * @param $message
     * @param int $code
     * @param string $status
     * @return mixed
     */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = 'ERROR')
    {
        return $this->setStatusCode($code)->message($message, $status);
    }

    /**
     * Notes:
     * @Author: <C.Jason>
     * @Date: 2020/1/14 5:17 下午
     * @param $status
     * @param array $data
     * @param null $code
     * @return mixed
     */
    protected function status($status, array $data, $code = null)
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
     * @Date: 2020/1/14 5:17 下午
     * @param $data
     * @param array $header
     * @return mixed
     */
    protected function respond($data, $header = [])
    {
        return Response::json($data, 200, $header);
    }

}
