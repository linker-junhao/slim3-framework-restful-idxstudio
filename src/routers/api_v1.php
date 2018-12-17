<?php

/**
 * 名称：api 接口
 * 版本：1.0
 *
 */

//不需要授权的公共资源
$app->get('/api/v1/test/{id}', App\Http\Controllers\SysAuth::class . ':setToken');

$app->post('/api/token_transfer', App\Http\Controllers\TokenTransfer::class . ':setTokenTransfer');


//需要授权的资源
$app->group('', function () use ($app) {
    //仅需要授权的资源
    // $app->get('/date', function ($request, $response) {
    //     return $response->getBody()->write(date('Y-m-d H:i:s'));
    // });

    //需要检查是否是本人访问的私人资源
    $app->group('/{uid}', function () use ($app) {
        $app->get('/date', function ($request, $response) {
            return $response->getBody()->write(date('Y-m-d H:i:s'));
        });
    })->add(new \Middleware\SlimRestful\SlimRestfulPrivateAuthCheck($app->getContainer()));

    //需要检查是否是本角色访问的角色资源
    $app->group('/{role}', function () use ($app) {

    })->add(new \Middleware\SlimRestful\SlimRestfulRoleAuthCheck($app->getContainer()));

})->add(new \Middleware\SlimRestful\SlimRestfulBasicAuthCheck($app->getContainer()));
