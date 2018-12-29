<?php
namespace App\Http\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class SysAuth extends AbstractController
{
    /**
     * 添加一个restful接口使用的认证
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function setToken(Request $request, Response $response, array $args)
    {
        $authorizeToken = new \IdxLib\Middleware\SlimRestful\AuthToken($this->ci);
        $authorizeToken->setUid('sdf111')->setRole('1234')->addAllowedResource("sss",array())->tokenAuthDone();
        return $response;
    }

}