<?php

$app->get('/apps', App\Http\Controllers\WebPage::class . ':appCenter')->setName('apps');

$app->group('/token_transfer', function () use ($app){
    $app->get('/distribute', App\Http\Controllers\TokenTransfer::class . ':tokenTransferRedirect');
});
