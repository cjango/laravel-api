<?php

namespace Jason\Api\Exception;

use Throwable;
use Response;

class Handler
{

    public static function render($request, Throwable $exception)
    {
        return Response::json([
            'status'      => 'EXCEPTION',
            'status_code' => $exception->getCode(),
            'message'     => $exception->getMessage(),
            'exception'   => $exception->getFile(),
            'api_uri'     => $request->url(),
        ]);
    }
}
