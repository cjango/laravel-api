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

修改 App\Exceptions\Handler 文件
```php
public function render($request, Throwable $exception)
{
    if ($request->is('api/*')) {
        return \Jason\Api\Exception\Handler::render($exception);
    } else {
        return parent::render($request, $exception);
    }
}
```
## 3.身份认证

User模型中，引入trait

```php

use Jason\Api\Traits\ApiGuardable;

```
