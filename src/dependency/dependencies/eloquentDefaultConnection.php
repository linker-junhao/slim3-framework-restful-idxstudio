<?php
function ($container)
{
    $capsule = new \Illuminate\Database\Capsule\Manager();

    //default
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};
