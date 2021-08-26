<?php

namespace Jason\Api;

use Illuminate\Support\Facades\Facade;

/**
 * Class Api
 * @package Jason
 * @method static \Jason\Api\Factory userId()
 * @method static \Jason\Api\Factory user()
 * @method static \Jason\Api\Factory check()
 * @method static \Jason\Api\Factory guest()
 */
class Api extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'api';
    }

}
