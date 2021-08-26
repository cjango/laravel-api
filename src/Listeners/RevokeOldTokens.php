<?php

namespace Jason\Api\Listeners;

use Laravel\Passport\Token;

class RevokeOldTokens
{

    public function handle($event)
    {
        if (config('api.token_auto_revoke')) {
            Token::where('user_id', $event->userId)
                 ->where('client_id', $event->clientId)
                 ->where('id', '<>', $event->tokenId)
                 ->update(['revoked' => 1]);
        }
    }

}