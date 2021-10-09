# LaravelAPI

![StyleCi](https://github.styleci.io/repos/233508941/shield?branch=sanctum&style=flat)
[![License](https://img.shields.io/packagist/l/jasonc/api.svg)](LICENSE)
[![Development Version](https://img.shields.io/packagist/vpre/jasonc/api.svg)](https://packagist.org/packages/jasonc/api)
[![Monthly Installs](https://img.shields.io/packagist/dt/jasonc/api.svg)](https://packagist.org/packages/jasonc/api)
![PHP](https://img.shields.io/packagist/php-v/jasonc/api.svg)
![laravel](https://img.shields.io/badge/Laravel-7.0+-ef3b2d.svg)

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
