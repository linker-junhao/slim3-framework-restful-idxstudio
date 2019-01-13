<?php
namespace App\Http\Controllers;

use IdxLib\Middleware\SlimRestful\Standard\HttpResponse\IDXResponse;
use IdxLib\Middleware\SlimRestful\Util\HandlerSetIDXResponseErr;
use IdxLib\Standard\BindViewData\BindViewData;
use IdxLib\util\FormValidation\Validation;
use Slim\Http\Request;
use Slim\Http\Response;

class YibanAppCollection extends AbstractController
{
    public function appCollectionListWebPage(Request $request, Response $response, array $args)
    {
        $bindViewData = new BindViewData();
        $bindViewData->setStatus(true);
        $bm = new \App\Models\BM\YibanAppCollection();
        $bindViewData->setData($bm->lists(
            array(
                'start' => 0,
                'limit' => 500
            )
        ));
        $bindViewData->setStatus(true);
        $this->ci->view->render($response, 'appCollection.twig', $bindViewData->toArray());
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
            HandlerSetIDXResponseErr::setErr400();
        } else {
            $bm = new \App\Models\BM\YibanAppCollection();
            HandlerSetIDXResponseErr::setErr200();
            $params = $request->getQueryParams();
            IDXResponse::setBodyData($bm->lists(
                $params
            ));
        }
        return $response;
    }

    public function dataAppend(Request $request, Response $response, array $args)
    {
        $bm = new \App\Models\BM\YibanAppCollection();
        $bm->append($request->getParsedBody());
        return $response;
    }

    public function dataModify(Request $request, Response $response, array $args)
    {
        $bm = new \App\Models\BM\YibanAppCollection();
        $bm->modify($request->getParsedBody());
        return $response;
    }

    public function dataDelete(Request $request, Response $response, array $args)
    {
        $bm = new \App\Models\BM\YibanAppCollection();
        $bm->delete($request->getQueryParams());
        return $response;
    }
}