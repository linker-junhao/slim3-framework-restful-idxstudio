<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/13
 * Time : 18:04
 */
$app->add(function ($request, $response, $next) use ($app) {
    $capsule = new \Illuminate\Database\Capsule\Manager();

    //default
    $capsule->addConnection($app->getContainer()['settings']['db']);
    //cms
    $capsule->addConnection($app->getContainer()['settings']['cms']['db'], 'cms');
    //slimRestful
    $capsule->addConnection($app->getContainer()['settings']['slimRestfulSetting']['db'], 'slimRestful');

    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    $response = $next($request, $response);
    return $response;
});
$app->group('', function () use ($app) {
    require 'yibanAppCollection.php';
    require 'tokenTransfer.php';
    require 'yibanCrxToolBox.php';
    require 'yibanResetPass.php';
    require 'SysAccessLog.php';
    require 'cms/cmsAdmin.php';
})->add(new \IdxLib\Middleware\Logger\AccessLogger($app->getContainer()));