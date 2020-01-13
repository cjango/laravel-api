<?php

namespace Jason\Api\Facades;

use Illuminate\Support\Facades\Facade;

class Api extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Jason\Api\Api::class;
    }
}
