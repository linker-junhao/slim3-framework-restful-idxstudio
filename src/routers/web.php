<?php

$app->get('/apps', App\Http\Controllers\WebPage::class . ':appCenter')->setName('apps');
$app->post('/apps', App\Http\Controllers\WebPage::class . ':appCenter')->setName('apps1');

$app->group('/token_transfer', function () use ($app){
    $app->get('/distribute', App\Http\Controllers\TokenTransfer::class . ':tokenTransferRedirect');
});





$app->get('/resetPass', App\Http\Controllers\ResetPass::class . ':get')->setName('resetPass');
$app->post('/resetPass', App\Http\Controllers\ResetPass::class . ':post')->setName('resetPass');


$app->get('/resetPassResult/{result_check_code}', App\Http\Controllers\ResetPass::class . ':resetPassResult')->setName('resetPassResult');