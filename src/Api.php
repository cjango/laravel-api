<?php

namespace Jason\Api;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Facade;

/**
 * Class Api
 * @package Jason
 * @method static string attempt(array $credentials, array $scopes = [])
 * @method static string login(User $user, array $scopes = [])
 * @method static int userId()
 * @method static User user()
 * @method static bool check()
 * @method static bool guest()
 */
class Api extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'api';
    }

}
