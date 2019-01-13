<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2018/12/28
 * Time : 22:26
 */


$app->group('/yiban', function () use ($app) {
    //api统一返回值处理
    $app->group('/api', function () use ($app) {
        //需要授权的资源
        $app->group('', function () use ($app) {
            //重置密码
            $app->group('/reset_pass', function () use ($app) {
                $app->get('', App\Http\Controllers\YibanResetPass::class . ':dataCollection');
                $app->post('', App\Http\Controllers\YibanResetPass::class . ':dataAppend');
                $app->put('', App\Http\Controllers\YibanResetPass::class . ':dataModify');
                $app->delete('', App\Http\Controllers\YibanResetPass::class . ':dataDelete');
            });
        })->add(new \IdxLib\Middleware\SlimRestful\BasicAuthCheck($app->getContainer()));
    })->add(new \IdxLib\Middleware\SlimRestful\RequestAndResponse());

    //网页请求
    $app->group('/web_page', function () use ($app) {
        $app->group('/reset_pass', function () use ($app) {
            $app->get('/apply', App\Http\Controllers\ResetPass::class . ':get')->setName('resetPass');
            $app->post('/apply', App\Http\Controllers\ResetPass::class . ':post')->setName('resetPass');
            $app->get('/apply_result/{result_check_code}', App\Http\Controllers\ResetPass::class . ':resetPassResult')->setName('resetPassResult');
        });
    });
});



