<?php
/**
 * 易班应用集路由
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
            $app->group('/app_collection', function () use ($app) {
                $app->get('', App\Http\Controllers\YibanAppCollection::class . ':dataCollection');
                $app->post('', App\Http\Controllers\YibanAppCollection::class . ':dataAppend');
                $app->put('', App\Http\Controllers\YibanAppCollection::class . ':dataModify');
                $app->delete('', App\Http\Controllers\YibanAppCollection::class . ':dataDelete');
            });
        })->add(new \IdxLib\Middleware\SlimRestful\BasicAuthCheck($app->getContainer()));
    })->add(new \IdxLib\Middleware\SlimRestful\RequestAndResponse());

    //网页请求
    $app->group('/web_page', function () use ($app) {
        $app->group('/app_collection', function () use ($app) {
            // 应用集列表
            $app->get('/list', App\Http\Controllers\YibanAppCollection::class . ':appCollectionListWebPage');
        });
    });
});


