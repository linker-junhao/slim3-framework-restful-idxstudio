<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2018/12/28
 * Time : 22:26
 */

$app->group('/token_transfer', function () use ($app) {
    $app->get('/state_url_map', App\Http\Controllers\TokenTransfer::class . ':tokenTransferMapList');
});
