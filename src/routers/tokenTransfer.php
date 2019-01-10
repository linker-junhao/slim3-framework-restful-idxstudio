<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2018/12/28
 * Time : 22:26
 */
// 统一第一级pattern
$app->group('/token_transfer', function () use ($app) {
    // api group
    $app->group('/api', function () use ($app) {
        $app->group('/state_url_map', function () use ($app) {
            /*获取token转发列表*/
            $app->get('', App\Http\Controllers\TokenTransfer::class . ':dataCollection');

            /*添加token转发*/
            $app->post('', App\Http\Controllers\TokenTransfer::class . ':dataAppend');

            /*修改token转发*/
            $app->put('', App\Http\Controllers\TokenTransfer::class . ':dataModify');

            /*删除token转发*/
            $app->delete('', App\Http\Controllers\TokenTransfer::class . ':dataDelete');

        })->add(new \IdxLib\Middleware\SlimRestful\BasicAuthCheck($app->getContainer()));//验证api权限

    })->add(new \IdxLib\Middleware\SlimRestful\RequestAndResponse());//统一处理返回结果

    // web_page group
    $app->group('/web_page', function () use ($app) {
        $app->get('/token_redirect', App\Http\Controllers\TokenTransfer::class . ':tokenTransferRedirect');
    });
});

