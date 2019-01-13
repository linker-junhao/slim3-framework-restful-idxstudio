<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/13
 * Time : 18:04
 */

$app->group('', function () use ($app) {
    require 'yibanAppCollection.php';
    require 'tokenTransfer.php';
    require 'yibanCrxToolBox.php';
    require 'yibanResetPass.php';
    require 'SysAccessLog.php';
})->add(new \IdxLib\Middleware\Logger\AccessLogger($app->getContainer()));