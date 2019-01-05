<?php
/**
 * Created by PhpStorm.
 * User: Linker
 * Date: 2018/12/15
 * Time: 22:04
 */

namespace App\Http\Controllers;

use App\Models\BM\authTokenTransfer;
use IdxLib\Middleware\SlimRestful\Standard\HttpResponse\IDXResponse;
use IdxLib\util\FormValidation\Validation;
use IdxLib\Util\YibanApi\YibanApi;
use Slim\Http\Request;
use Slim\Http\Response;

class TokenTransfer extends AbstractController
{
    /**
     * 基于传入的state参数重定向至目标应用地址并带上access_token参数
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function tokenTransferRedirect(Request $request, Response $response, array $args)
    {
        $tokenTransfer = new authTokenTransfer();
        $yibanApi = new YibanApi();
        $targetAppUrl = $tokenTransfer->getSubAuthUrlByState($request->getQueryParam('state'));
        $token = $yibanApi->getYibanAccessTokenByCode($request->getQueryParam('code'),
            'c09da94882a3eefb',
            'd5ba187dfc60ee1df04cf5c721546117',
            'http://localhost:8888/token_transfer/distribute'
        );
        $this->ci->view->render($response, 'redirectToApp.twig', array('redirectUrl' => $targetAppUrl . '?token=' . $token->access_token));
        return $response;
        //return $response->withRedirect($url, 301);
    }

    /**
     * 返回查询的数据集
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function dataCollection(Request $request, Response $response, array $args)
    {
        $valid = new Validation($this->ci);
        $valid->setQueryParamRegulation(
            array(
                'start' => 'numeric:0~-0',
                'limit' => 'numeric:0~500'
            )
        );
        if (!$valid->getIntegratedStatus()) {
            IDXResponse::setBodyStatus(false);
            IDXResponse::setBodyCode(400);
            IDXResponse::setHttpStatusCode(400);
        } else {
            $tokenTransfer = new authTokenTransfer();
            IDXResponse::setBodyData($tokenTransfer->getTokenTransferMapList(
                $request->getQueryParam('start'),
                $request->getQueryParam('limit')
            ));
            IDXResponse::setBodyStatus(true);
            IDXResponse::setBodyCode(200);
            IDXResponse::setHttpStatusCode(200);
        }
        return $response;
    }

    public function dataAppend(Request $request, Response $response, array $args)
    {
        $tokenTransfer = new authTokenTransfer();
        $tokenTransfer->appendTokenTransferMap($request->getParsedBody());
        return $response;
    }

    public function dataModify(Request $request, Response $response, array $args)
    {
        $tokenTransfer = new authTokenTransfer();
        $tokenTransfer->modifyTokenTransferMap($request->getParsedBody());
        return $response;
    }

    public function dataDelete(Request $request, Response $response, array $args)
    {
        $tokenTransfer = new authTokenTransfer();
        $tokenTransfer->deleteTokenTransferMap($request->getQueryParams());
        return $response;
    }
}