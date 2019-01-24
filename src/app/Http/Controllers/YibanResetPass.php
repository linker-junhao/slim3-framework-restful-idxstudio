<?php
/**
 * Created by PhpStorm.
 * User: Linker
 * Date: 2018/12/15
 * Time: 22:04
 */

namespace App\Http\Controllers;

use IdxLib\Standard\HttpResponse\IDXResponse;
use IdxLib\Standard\HttpResponse\HandlerSetIDXResponseErr;
use IdxLib\util\FormValidation\Validation;
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
            HandlerSetIDXResponseErr::setStatus400();
        } else {
            $bm = new \App\Models\BM\YibanResetPass();
            HandlerSetIDXResponseErr::setStatus200();
            $params = $request->getQueryParams();
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