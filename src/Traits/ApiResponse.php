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
     * [getStatusCode description]
     * @Author:<C.Jason>
     * @Date:2018-05-22
     * @return [type] [description]
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * [setStatusCode description]
     * @Author:<C.Jason>
     * @Date:2018-05-22
     * @param [type] $statusCode [description]
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * 成功的返回
     * @Author:<C.Jason>
     * @Date:2018-05-22
     * @param [type] $data [description]
     * @param string $status [description]
     * @return [type] [description]
     */
    public function success($data, $status = "SUCCESS")
    {
        return $this->status($status, compact('data'));
    }

    /**
     * 200 返回消息
     * @Author:<C.Jason>
     * @Date:2018-05-22
     * @param [type] $message [description]
     * @param string $status [description]
     * @return [type] [description]
     */
    public function message($message, $status = "SUCCESS")
    {
        return $this->status($status, [
            'message' => $message,
        ]);
    }

    /**
     * 400 失败
     * @Author:<C.Jason>
     * @Date:2018-05-22
     * @param [type] $message [description]
     * @param [type] $code [description]
     * @param string $status [description]
     * @return [type] [description]
     */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = 'ERROR')
    {
        return $this->setStatusCode($code)->message($message, $status);
    }

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

    protected function respond($data, $header = [])
    {
        return Response::json($data, 200, $header);
    }
}
