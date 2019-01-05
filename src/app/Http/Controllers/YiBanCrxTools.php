<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/5
 * Time : 21:51
 */

namespace App\Http\Controllers;

use IdxLib\Middleware\SlimRestful\Standard\HttpResponse\IDXResponse;
use Slim\Http\Request;
use Slim\Http\Response;

class YiBanCrxTools extends AbstractController
{
    function login(Request $request, Response $response, array $args)
    {
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyData('');
        IDXResponse::setBodyErr('用户名密码错误');
        return $response;
    }
}