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

namespace IdxLib\Middleware\SlimRestful\Util;

class SlimRestfulDatabase
{
    public static function restfulEloquentConnectionReady($config)
    {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($config, 'slimRestful');
        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        return $capsule;
    }
}
