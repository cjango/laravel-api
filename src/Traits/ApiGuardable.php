<?php

namespace Jason\Api\Traits;

trait ApiGuardable
{

    /**
     * JWT.获取要储存到 jwt sub 中的标识
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * JWT.返回包含要添加到 jwt 声明中的自定义键值对数组
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
