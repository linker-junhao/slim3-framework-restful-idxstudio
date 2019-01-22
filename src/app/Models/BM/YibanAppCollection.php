<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/13
 * Time : 12:35
 */

namespace App\Models\BM;


use App\Models\ORM\YbAppCollectionORM;
use IdxLib\Middleware\SlimRestful\Standard\HttpResponse\IDXResponse;

class YibanAppCollection extends AbstractBM
{
    /**
     * 查询
     * @param $params
     * @return mixed
     */
    public function lists($params)
    {
        $ybAppCollectionOrm = new YbAppCollectionORM();
        if (isset($params['app_name']) && $params['app_name'] != '') {
            $ybAppCollectionOrm = $ybAppCollectionOrm->where('app_name', 'like', '%' . $params['app_name'] . '%');
        }
        if (isset($params['app_url']) && $params['app_url'] != '') {
            $ybAppCollectionOrm = $ybAppCollectionOrm->where('app_url', 'like', '%' . $params['app_url'] . '%');
        }
        if (isset($params['enable']) && $params['enable'] != '') {
            $ybAppCollectionOrm = $ybAppCollectionOrm->where('enable', '=', $params['enable']);
        }

        return array(
            'rows' => $ybAppCollectionOrm->skip($params['start'])->take($params['limit'])->get()->toArray(),
            'total' => $ybAppCollectionOrm->count()
        );
    }

    public function append($params)
    {
        $ybAppCollectionOrm = new YbAppCollectionORM();
        foreach ($params as $colName => $val) {
            $ybAppCollectionOrm->$colName = $val;
        }
        $ybAppCollectionOrm->save();
        $ret = $ybAppCollectionOrm->toArray();
        unset($ret['updated_at']);

        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData($ret);
    }

    public function delete($params)
    {
        $id = explode(',', $params['id']);
        $ybAppCollectionOrm = new YbAppCollectionORM();
        $ybAppCollectionOrm::destroy($id);
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData('');
    }

    public function modify($params)
    {
        foreach ($params as $rowItem) {
            $ybAppCollectionOrm = YbAppCollectionORM::find($rowItem['id']);
            unset($rowItem['created_at']);
            unset($rowItem['updated_at']);
            unset($rowItem['id']);
            foreach ($rowItem as $colName => $val) {
                $ybAppCollectionOrm->$colName = $val;
            }
            $ybAppCollectionOrm->save();
        }
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData('');
    }
}