<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/13
 * Time : 12:35
 */

namespace App\Models\BM;


use App\Models\ORM\SysAccessLogORM;
use IdxLib\Middleware\SlimRestful\Standard\HttpResponse\IDXResponse;

class SysAccessLog extends AbstractBM
{
    /**
     * 查询
     * @param $params
     * @return mixed
     */
    public function lists($params)
    {
        $orm = new SysAccessLogORM();
        if (isset($params['level']) && $params['level'] != '') {
            $orm = $orm->where('level', '=', $params['level']);
        }
        if (isset($params['url']) && $params['url'] != '') {
            $orm = $orm->where('url', 'like', '%' . $params['url'] . '%');
        }
        if (isset($params['ip_addr']) && $params['ip_addr'] != '') {
            $orm = $orm->where('ip_addr', 'like', '%' . $params['ip_addr'] . '%');
        }
        if (isset($params['http_status']) && $params['http_status'] != '') {
            $orm = $orm->where('http_status', '=', $params['http_status']);
        }

        return array(
            'rows' => $orm->skip($params['start'])->take($params['limit'])->get()->toArray(),
            'total' => $orm->count()
        );
    }

    public function append($params)
    {
        $orm = new SysAccessLogORM();
        foreach ($params as $colName => $val) {
            $orm->$colName = $val;
        }
        $orm->save();
        $ret = $orm->toArray();
        unset($ret['updated_at']);

        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData($ret);
    }

    public function delete($params)
    {
        $id = explode(',', $params['id']);
        $orm = new SysAccessLogORM();
        $orm::destroy($id);
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData('');
    }

    public function modify($params)
    {
        foreach ($params as $rowItem) {
            $orm = SysAccessLogORM::find($rowItem['id']);
            unset($rowItem['created_at']);
            unset($rowItem['updated_at']);
            unset($rowItem['id']);
            foreach ($rowItem as $colName => $val) {
                $orm->$colName = $val;
            }
            $orm->save();
        }
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData('');
    }
}