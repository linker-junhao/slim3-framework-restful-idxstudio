<?php
/**
 * 易班chrome扩展业务
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/5
 * Time : 21:46
 */


// 统一第一级pattern
$app->group('/yiban_crx_toolbox', function () use ($app) {
    // api group
    $app->group('/api', function () use ($app) {
        // 扩展登陆
        $app->post('/login', \App\Http\Controllers\YiBanCrxTools::class . ':login');
    })->add(new \IdxLib\Middleware\SlimRestful\RequestAndResponse());
    // web_page group
    $app->group('/web_page', function () use ($app) {

    });
});