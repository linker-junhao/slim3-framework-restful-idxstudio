<?php

$app->get('/apps', App\Http\Controllers\WebPage::class . ':appCenter')->setName('apps');
$app->post('/apps', App\Http\Controllers\WebPage::class . ':appCenter')->setName('apps1');

$app->group('/token_transfer', function () use ($app){
    $app->get('/distribute', App\Http\Controllers\TokenTransfer::class . ':tokenTransferRedirect');
});




