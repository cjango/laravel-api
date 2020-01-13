<?php

use Illuminate\Routing\Router;

Route::group([
    'domain'     => config('api.route.domain'),
    'prefix'     => config('api.route.prefix'),
    'namespace'  => config('api.route.namespace'),
    'middleware' => config('api.route.middleware'),
], function (Router $router) {

    $router->get('/', 'IndexController@index');

});
