<?php
/**
 * Created by PhpStorm.
 * User: Linker
 * Date: 2018/12/15
 * Time: 22:04
 */

namespace App\Http\Controllers;

use App\Models\BM\AuthTokenTransfer;
use IdxLib\Middleware\SlimRestful\Standard\HttpResponse\IDXResponse;
use IdxLib\Middleware\SlimRestful\Util\HandlerSetIDXResponseErr;
use IdxLib\Standard\BindViewData\BindViewData;
use IdxLib\util\FormValidation\Validation;
use IdxLib\Util\YibanApi\YibanApi;
use Slim\Http\Request;
use Slim\Http\Response;

class TokenTransfer extends AbstractController implements ApiControllerInterface
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
        $tokenTransfer = new AuthTokenTransfer();
        $targetApp = $tokenTransfer->getSubAuthInfoByState($request->getQueryParam('state'));

        $bindViewData = new BindViewData();
        if (isset($targetApp->sub_auth_url)) {
            $yibanApi = new YibanApi();
            $token = $yibanApi->getYibanAccessTokenByCode($request->getQueryParam('code'),
                'c09da94882a3eefb',
                'd5ba187dfc60ee1df04cf5c721546117',
                'http://localhost:8888/token_transfer/web_page/token_redirect'
            );
            if (isset($token->access_token)) {
                $bindViewData->setData(
                    array(
                        'redirectUrl' => $targetApp->sub_auth_url . '?token=' . $token->access_token,
                        'targetName' => $targetApp->site_name
                    )
                )->setStatus(true);
            } else {
                $bindViewData->setError('您的授权已过期，请重新登陆！')->setStatus(false);
            }
        } else {
            $bindViewData->setError('可能由于该目标应用被删除或禁用，没有找到该目标应用!')->setStatus(false);
        }

        $this->ci->view->render($response, 'tokenRedirectToApp.twig', $bindViewData->toArray());
        return $response;
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
            HandlerSetIDXResponseErr::setStatus400();
        } else {
            $tokenTransfer = new AuthTokenTransfer();
            IDXResponse::setBodyData($tokenTransfer->getTokenTransferMapList(
                $request->getQueryParams()
            ));
            HandlerSetIDXResponseErr::setStatus200();
        }
        return $response;
    }

    public function dataAppend(Request $request, Response $response, array $args)
    {
        $tokenTransfer = new AuthTokenTransfer();
        $tokenTransfer->appendTokenTransferMap($request->getParsedBody());
        return $response;
    }

    public function dataModify(Request $request, Response $response, array $args)
    {
        $tokenTransfer = new AuthTokenTransfer();
        $tokenTransfer->modifyTokenTransferMap($request->getParsedBody());
        return $response;
    }

    public function dataDelete(Request $request, Response $response, array $args)
    {
        $tokenTransfer = new AuthTokenTransfer();
        $tokenTransfer->deleteTokenTransferMap($request->getQueryParams());
        return $response;
    }
}