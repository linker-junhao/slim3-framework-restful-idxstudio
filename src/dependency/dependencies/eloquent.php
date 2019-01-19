<?php
return function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager();

    //default
    $capsule->addConnection($container['settings']['db']);

    //cms
    $capsule->addConnection($container['settings']['cms']['db'], 'cms');

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};