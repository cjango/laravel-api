<?php

namespace Jason\Api\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Unauthenticated.', 401);
    }
}
