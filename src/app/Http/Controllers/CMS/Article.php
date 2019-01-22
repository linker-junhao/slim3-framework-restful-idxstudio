<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/19
 * Time : 17:43
 */

namespace App\Http\Controllers\CMS;


use App\Http\Controllers\ApiControllerInterface;
use IdxLib\Middleware\SlimRestful\Standard\HttpResponse\IDXResponse;
use IdxLib\Middleware\SlimRestful\Util\HandlerSetIDXResponseErr;
use IdxLib\util\FormValidation\Validation;
use Slim\Http\Request;
use Slim\Http\Response;

class Article extends CMSAbstractController implements ApiControllerInterface
{
    // 指定基本操作BM类
    private $BMClass = \App\Models\BM\CMS\Article::class;

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
            $bm = new $this->BMClass();
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
        $bm = new $this->BMClass();
        $bm->append($request->getParsedBody());
        return $response;
    }

    public function dataModify(Request $request, Response $response, array $args)
    {
        $bm = new $this->BMClass();
        $bm->modify($request->getParsedBody());
        return $response;
    }

    public function dataDelete(Request $request, Response $response, array $args)
    {
        $bm = new $this->BMClass();
        $bm->delete($request->getQueryParams());
        return $response;
    }

    public function thumbPicFileAppend(Request $request, Response $response, array $args)
    {
        $files = $request->getUploadedFiles();
        if (empty($files['file'])) {
            throw new \Exception('Expected a file');
        }
        $thumbPic = $files['file'];
        if ($thumbPic->getError() === UPLOAD_ERR_OK) {
            $uploadFileName = $thumbPic->getClientFilename();
            $thumbPic->moveTo($this->_ARTICLE_COVER['save_path'] . $uploadFileName);
            HandlerSetIDXResponseErr::setStatus200();
            IDXResponse::setBodyData(array(
                'url' => $this->_ARTICLE_COVER['base_url'] . urlencode($uploadFileName)
            ));
        } else {
            HandlerSetIDXResponseErr::setStatus500();
            IDXResponse::setBodyErr($thumbPic->getError());
        }
    }
}