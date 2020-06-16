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
            'status_code' => $e->getStatusCode(),
            'message'     => $e->getMessage(),
            'exception'   => get_class($e),
            'api_uri'     => $request->url(),
        ]);
    }

}
