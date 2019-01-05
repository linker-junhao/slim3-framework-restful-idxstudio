<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/5
 * Time : 21:46
 */

$app->group('', function () use ($app) {
    $app->group('/yiban_crx_toolbox', function () use ($app) {
        $app->post('/login', \App\Http\Controllers\YiBanCrxTools::class . ':login');
    });
})->add(new \IdxLib\Middleware\SlimRestful\RequestAndResponse());