<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/19
 * Time : 18:01
 */


// 统一第一级pattern
$app->group('/cms', function () use ($app) {
    // api group
    $app->group('/api', function () use ($app) {
        $app->group('', function () use ($app) {
            //需要检查是否是本角色访问的角色资源
            $app->group('/{role}', function () use ($app) {
                //add some route
                $app->group('/article', function () use ($app) {
                    //add some route
                    $app->get('', \App\Http\Controllers\CMS\Article::class . ':dataCollection');
                    $app->post('', \App\Http\Controllers\CMS\Article::class . ':dataAppend');
                    $app->put('', \App\Http\Controllers\CMS\Article::class . ':dataModify');
                    $app->delete('', \App\Http\Controllers\CMS\Article::class . ':dataDelete');
                    $app->options('', function ($request, $response, array $args) {
                        \IdxLib\Middleware\SlimRestful\Util\HandlerSetIDXResponseErr::setStatus200();
                        return $response;
                    });

                    $app->group('/thumb_pic', function () use ($app) {
                        //add some route
                        $app->post('', \App\Http\Controllers\CMS\Article::class . ':thumbPicFileAppend');
                        $app->options('', function ($request, $response, array $args) {
                            \IdxLib\Middleware\SlimRestful\Util\HandlerSetIDXResponseErr::setStatus200();
                            return $response;
                        });
                    });
                });
            });//->add(new \IdxLib\Middleware\SlimRestful\RoleAuthCheck($app->getContainer()));//注释掉权限验证方便测试
        });//->add(new \IdxLib\Middleware\SlimRestful\BasicAuthCheck($app->getContainer()));//验证api权限

    })->add(new \IdxLib\Middleware\SlimRestful\RequestAndResponse());//统一处理返回结果

    // web_page group
    $app->group('/web_page', function () use ($app) {

    });
});