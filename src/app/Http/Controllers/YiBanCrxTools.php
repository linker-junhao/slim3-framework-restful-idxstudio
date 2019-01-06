<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/5
 * Time : 21:51
 */

namespace App\Http\Controllers;

use App\Models\BM\SysAdmin;
use Slim\Http\Request;
use Slim\Http\Response;

class YiBanCrxTools extends AbstractController
{
    function login(Request $request, Response $response, array $args)
    {
        $admin = new SysAdmin();
        $admin->login($this->ci, $request->getParsedBody());
        return $response;
    }
}