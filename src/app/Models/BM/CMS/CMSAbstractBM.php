<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/19
 * Time : 14:49
 */

namespace App\Models\BM\CMS;


use IdxLib\Middleware\SlimRestful\Standard\HttpResponse\IDXResponse;

class CMSAbstractBM
{
    protected $ORMClass = null;

    protected function listsDeal(\Illuminate\Database\Eloquent\Model $orm)
    {

    }

    protected function appendDeal(\Illuminate\Database\Eloquent\Model $orm)
    {

    }

    protected function deleteDeal(\Illuminate\Database\Eloquent\Model $orm)
    {

    }

    protected function modifyDeal(\Illuminate\Database\Eloquent\Model $orm)
    {

    }

    public function __construct()
    {
    }

    /**
     * 查询
     * @param $params
     * @return mixed
     */
    public function lists($params)
    {
        $ORM = new $this->ORMClass();
        $this->listsDeal($ORM);
        return array(
            'rows' => $ORM->skip($params['start'])->take($params['limit'])->get()->toArray(),
            'total' => $ORM->count()
        );
    }

    public function append($params)
    {
        $ORM = new $this->ORMClass();
        foreach ($params as $colName => $val) {
            $ORM->$colName = $val;
        }
        $ORM->save();
        $ret = $ORM->toArray();
        $this->appendDeal($ORM);
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData($ret);
    }

    public function delete($params)
    {
        $id = explode(',', $params['id']);
        $ORM = new $this->ORMClass();
        $ORM::destroy($id);
        $this->deleteDeal($ORM);
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData('');
    }

    public function modify($params)
    {
        foreach ($params as $rowItem) {
            $ORM = $this->ORMClass::find($rowItem['id']);
            unset($rowItem['created_at']);
            unset($rowItem['updated_at']);
            unset($rowItem['id']);
            foreach ($rowItem as $colName => $val) {
                $ORM->$colName = $val;
            }
            $ORM->save();
            $this->modifyDeal($ORM);
        }
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData('');
    }
}