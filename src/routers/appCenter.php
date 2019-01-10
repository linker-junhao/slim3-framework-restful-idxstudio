<?php

$app->get('/apps', App\Http\Controllers\WebPage::class . ':appCenter')->setName('apps');




