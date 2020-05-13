# LaravelAPI

## 1.安装
```shell script
$ composer require jasonc/api

$ php artisan api:install

$ php artisan vendor:publish
```

## 2.使用

```php
return $this->success();
return $this->failed();
```

## 3.修改 App\Exceptions\Handler 文件，引入Trait
```php
use Jason\Api\Traits\ApiException;

use ApiException;
```
> 客户端访问的时候，注意要在头信息中增加 Accept: application/json 或 Accept: application/vnd.api+json
## 4.身份认证

User模型中，引入trait

```php

use Jason\Api\Traits\ApiGuardable;

```
