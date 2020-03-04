<?php

namespace Jason;

use Illuminate\Support\Facades\Facade;

class Api extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Api\Api::class;
    }
}
