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
use IdxLib\util\FormValidation\Validation;
use IdxLib\Util\YibanApi\YibanApi;
use Slim\Http\Request;
use Slim\Http\Response;

class YibanResetPass extends AbstractController
{
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
            HandlerSetIDXResponseErr::setErr400();
        } else {
            $bm = new \App\Models\BM\YibanResetPass();
            HandlerSetIDXResponseErr::setErr200();
            $params = $request->getQueryParams();
            if (($deal_code = $request->getAttribute('route')->getArgument('status')) != null) {
                $params['deal_code'] = $deal_code;
            }
            IDXResponse::setBodyData($bm->lists(
                $params
            ));
        }
        return $response;
    }

    public function dataAppend(Request $request, Response $response, array $args)
    {
        $bm = new \App\Models\BM\YibanResetPass();
        $bm->append($request->getParsedBody());
        return $response;
    }

    public function dataModify(Request $request, Response $response, array $args)
    {
        $bm = new \App\Models\BM\YibanResetPass();
        $bm->modify($request->getParsedBody());
        return $response;
    }

    public function dataDelete(Request $request, Response $response, array $args)
    {
        $bm = new \App\Models\BM\YibanResetPass();
        $bm->delete($request->getQueryParams());
        return $response;
    }
}