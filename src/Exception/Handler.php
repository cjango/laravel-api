<?php

namespace Jason\Api\Exception;

use Exception;
use Response;

class Handler
{

    public function render($request, Exception $exception)
    {
        return Response::json([
            'status'      => 'EXCEPTION',
            'status_code' => $this->tryGetStatusCode($exception),
            'message'     => $this->tryGetErrorMessage($exception),
            'exception'   => get_class($exception),
            'api_uri'     => $request->url(),
        ]);
    }

    protected function tryGetErrorMessage(Exception $exception)
    {
        if (method_exists($exception, 'errors')) {
            return $exception->errors();
        } else {
            return $exception->getMessage();
        }
    }

    protected function tryGetStatusCode(Exception $exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            return $exception->getStatusCode();
        } else {
            return $exception->getCode();
        }
    }
}
