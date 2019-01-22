<?php
/*
 * File: AbstractController.php
 * File Created: Tuesday, 16th October 2018 2:04:41 pm
 * Author: Linker (linker-junhao@outlook.com)
 * -----
 * Last Modified: Tuesday, 16th October 2018 2:18:55 pm
 * Modified By: Linker (linker-junhao@outlook.com)
 * -----
 * Copyright 2018 - 2018 Linker, IDX STUDIO
 */
namespace App\Http\Controllers;

use Interop\Container\ContainerInterface;

abstract class AbstractController
{
    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }
}