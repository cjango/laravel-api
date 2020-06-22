<?php

namespace Jason;

use Illuminate\Support\Facades\Facade;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Api
 * @package Jason
 * @method static \Jason\Api\Api attempt(array $credentials)
 * @method static \Jason\Api\Api login(JWTSubject $user)
 * @method static \Jason\Api\Api id()
 * @method static \Jason\Api\Api user()
 */
class Api extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Api\Api::class;
    }
}
