<?php

namespace Jason\Api\Listeners;

class LoginListener
{

    public function handle($event)
    {
        if (config('api.token_auto_revoke')) {
            $event->user->tokens()->delete();
        }
    }

}
