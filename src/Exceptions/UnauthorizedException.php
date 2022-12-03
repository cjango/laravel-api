<?php

namespace Jason\Api\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    public function __construct()
    {
        parent::__construct('未登录或登录凭证已过期.', 401);
    }
}
