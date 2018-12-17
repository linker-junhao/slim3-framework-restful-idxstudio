<?php
/*
 * File: SlimRestfulDatabase.php
 * File Created: Monday, 10th December 2018 1:27:37 am
 * Author: Linker (linker-junhao@outlook.com)
 * -----
 * Last Modified: Monday, 10th December 2018 1:27:52 am
 * Modified By: Linker (linker-junhao@outlook.com)
 * -----
 * Copyright 2018 - 2018 Linker, IDX STUDIO
 */

namespace Middleware\SlimRestful\Util;

class SlimRestfulDatabase
{
    public static function restfulEloquentConnectionReady($container)
    {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($container->get('settings')['slimRestfulSetting']['db']);
    
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    
        return $capsule;
    }
}
