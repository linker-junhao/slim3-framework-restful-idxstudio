<?php
/**
 * Created by PhpStorm.
 * User: Linker
 * Date: 2018/12/15
 * Time: 16:07
 */

namespace App\Models\BM;

use App\Models\ORM\YbResetPass;
use IdxLib\Middleware\SlimRestful\Standard\HttpResponse\IDXResponse;

class YibanResetPass
{
    public function __construct()
    {
    }

    /**
     * 查询
     * @param int $start 查询开始的的偏移量
     * @param int $limit 想要获取的数量
     * @return mixed
     */
    public function lists($start, $limit)
    {
        $ybResetPassOrm = new YbResetPass();
        return array(
            'rows' => $ybResetPassOrm->skip($start)->take($limit)->get()->toArray(),
            'total' => $ybResetPassOrm->count()
        );
    }

    public function append($params)
    {
        $ybResetPassOrm = new YbResetPass();
        foreach ($params as $colName => $val) {
            $ybResetPassOrm->$colName = $val;
        }
        $ybResetPassOrm->save();
        $ret = $ybResetPassOrm->toArray();
        unset($ret['updated_at']);

        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData($ret);
    }

    public function delete($params)
    {
        $id = explode(',', $params['id']);
        $ybResetPassOrm = new YbResetPass();
        $ybResetPassOrm::destroy($id);
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData('');
    }

    public function modify($params)
    {
        foreach ($params as $rowItem) {
            $ybResetPassOrm = YbResetPass::find($rowItem['id']);
            unset($rowItem['created_at']);
            unset($rowItem['updated_at']);
            unset($rowItem['id']);
            foreach ($rowItem as $colName => $val) {
                $ybResetPassOrm->$colName = $val;
            }
            $ybResetPassOrm->save();
        }
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData('');
    }
}