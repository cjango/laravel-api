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

修改 App\Exceptions\Handler 文件，引入Trait
```php
use Jason\Api\Traits\ApiException;

use ApiException;
```
## 3.身份认证

User模型中，引入trait

```php

use Jason\Api\Traits\ApiGuardable;

```
