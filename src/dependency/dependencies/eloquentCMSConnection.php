<?php
function ($container)
{
    $capsule = new \Illuminate\Database\Capsule\Manager();

    //cms
    $capsule->addConnection($container['settings']['cms']['db'], 'cms');

    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
}

;
