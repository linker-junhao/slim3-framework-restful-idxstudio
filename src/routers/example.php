<?php

/**
 * 名称：路由样例
 * 版本：1.0
 *
 */

// 统一第一级pattern
$app->group('/example', function () use ($app) {
    // api group
    $app->group('/api', function () use ($app) {
        $app->group('/sub_business1', function () use ($app) {

            //需要检查是否是本人访问的私人资源
            $app->group('/{uid}', function () use ($app) {

            })->add(new \IdxLib\Middleware\SlimRestful\PrivateAuthCheck($app->getContainer()));


            //需要检查是否是本角色访问的角色资源
            $app->group('/{role}', function () use ($app) {

            })->add(new \IdxLib\Middleware\SlimRestful\RoleAuthCheck($app->getContainer()));

        })->add(new \IdxLib\Middleware\SlimRestful\BasicAuthCheck($app->getContainer()));//验证api权限

    })->add(new \IdxLib\Middleware\SlimRestful\RequestAndResponse());//统一处理返回结果

    // web_page group
    $app->group('/web_page', function () use ($app) {

    });
});
