<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2018/12/28
 * Time : 22:26
 */
//需要授权的资源
$app->group('', function () use ($app) {
    $app->group('/token_transfer', function () use ($app) {
        $app->group('/state_url_map', function () use ($app) {
            $app->get('', App\Http\Controllers\TokenTransfer::class . ':dataCollection');
            $app->post('', App\Http\Controllers\TokenTransfer::class . ':dataAppend');
            $app->put('', App\Http\Controllers\TokenTransfer::class . ':dataModify');
            $app->delete('', App\Http\Controllers\TokenTransfer::class . ':dataDelete');
        });
    })->add(new \IdxLib\Middleware\SlimRestful\BasicAuthCheck($app->getContainer()));
})->add(new \IdxLib\Middleware\SlimRestful\RequestAndResponse());

