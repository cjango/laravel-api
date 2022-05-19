<?php

namespace Jason\Api\Events;

use Illuminate\Contracts\Auth\Authenticatable;

class Authenticated
{
    public Authenticatable $user;

    /**
     * Create a new event instance.
     *
     * @param  Authenticatable  $user
     * @return void
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }
}
