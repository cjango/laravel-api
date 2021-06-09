# LaravelAPI
>快速构建laravel api服务
## 1.安装
```shell script
$ composer require jasonc/api

$ php artisan api:install

$ php artisan vendor:publish
```

## 2.使用

```php
return $this->message(string $message);
return $this->success(array $data);
return $this->failed(string $error);
```

## 3.修改 App\Exceptions\Handler 文件，引入Trait
```php
<?php

namespace App\Exceptions;

use Jason\Api\Traits\ApiException;

class Handler extends ExceptionHandler
{

    use ApiException;
}
```

## 4.身份认证

修改User模型

```php
<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Jason\Api\Traits\ApiGuardable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject 
{

    use ApiGuardable;
}




```
