<?php
function ($container)
{
    $capsule = new \Illuminate\Database\Capsule\Manager();

//    //slimRestful
    $capsule->addConnection($container['settings']['slimRestfulSetting']['db'], 'slimRestful');
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
}

;
