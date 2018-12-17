<?php
/**
 * Created by PhpStorm.
 * User: Linker
 * Date: 2018/12/15
 * Time: 22:04
 */

namespace App\Http\Controllers;

use App\Models\BM\authTokenTransfer;
use Slim\Http\Request;
use Slim\Http\Response;

class TokenTransfer extends AbstractController
{
    /**
     * 添加一个state和目标应用地址的token转发映射
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function setTokenTransfer(Request $request, Response $response, array $args){
        $tokenTransfer = new authTokenTransfer();
        $tokenTransfer->setSubAuthUrl($request->getParsedBodyParam('auth_url'))->setEnable('1')->addSubAuthDone();
        return $response;
    }

    /**
     * 基于传入的state参数重定向至目标应用地址并带上access_token参数
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function tokenTransferRedirect(Request $request, Response $response, array $args){
        $tokenTransfer = new authTokenTransfer();
        $targetAppUrl = $tokenTransfer->getSubAuthUrlByState($request->getQueryParam('state'));
        $token = $tokenTransfer->getYibanAccessTokenByCode($request->getQueryParam('code'));
        $this->ci->view->render($response, 'redirectToApp.twig', array('redirectUrl' => $targetAppUrl.'?token='.$token->access_token));
        return $response;
        //return $response->withRedirect($url, 301);
    }
}