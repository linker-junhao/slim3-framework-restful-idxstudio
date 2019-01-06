<?php
/**
 * Created by PhpStorm.
 * User: Linker
 * Date: 2018/12/15
 * Time: 16:07
 */

namespace App\Models\BM;

use App\Models\ORM\SubAuth;
use IdxLib\Middleware\SlimRestful\Standard\HttpResponse\IDXResponse;

class AuthTokenTransfer
{
    /**
     * 返回一个transfer适用的数组
     * @return array
     */
    private function transferArray()
    {
        return array(
            'state_value' => null,
            'sub_auth_url' => null,
            'site_name' => null,
            'enable' => null
        );
    }

    private $transfer;

    public function __construct()
    {
        $this->transfer = $this->transferArray();
    }

    /**
     * 设置一个State-目标url映射的state值，不建议调用此函数手动设置state值，不调用此函数将由系统自动生成state值
     * @param $id
     * @return $this
     */
    private function setId($id)
    {
        $this->transfer['id'] = $id;
        return $this;
    }

    /**
     * 设置一个State-目标url映射的state值，不建议调用此函数手动设置state值，不调用此函数将由系统自动生成state值
     * @param $stateValue
     * @return $this
     */
    private function setStateValue($stateValue)
    {
        $this->transfer['state_value'] = $stateValue;
        return $this;
    }

    /**
     * 设置state-目标url映射的url值
     * @param $subAuthUrl
     * @return $this
     */
    private function setSubAuthUrl($subAuthUrl)
    {
        $this->transfer['sub_auth_url'] = $subAuthUrl;
        return $this;
    }


    private function setSiteName($siteName)
    {
        $this->transfer['site_name'] = $siteName;
        return $this;
    }


    /**
     * 设置该映射的启用/禁用状态
     * @param $enableFlag
     * @return $this
     */
    private function setEnable($enableFlag)
    {
        $this->transfer['enable'] = $enableFlag;
        return $this;
    }

    /**
     * 将该映射存储到数据库中
     */
    private function addSubAuthDone()
    {
        if ($this->transfer['state_value'] == null) {
            $this->transfer['state_value'] = uniqid('sa');
        }
        $subAuth = new SubAuth();
        foreach ($this->transfer as $colName => $val) {
            $subAuth->$colName = $val;
        }
        $subAuth->save();
        $ret = $subAuth->toArray();
        unset($ret['updated_at']);
        return $ret;
    }

    /**
     * 将该映射存储到数据库中
     */
    private function updateSubAuthDone()
    {

        $colVal = $this->transfer;
        $subAuth = subAuth::find($colVal['id']);
        unset($colVal['created_at']);
        unset($colVal['updated_at']);
        unset($colVal['id']);
        foreach ($colVal as $colName => $val) {
            $subAuth->$colName = $val;
        }
        $subAuth->save();
        $ret = $subAuth->toArray();
        return $ret;
    }
    /**
     * 删除对应主键id的映射关系
     * @param array | int $id
     */
    private function deleteSubAuth($id)
    {
        $subAuth = new SubAuth();
        $subAuth::destroy($id);
    }

    /**
     * 通过state值获取其映射到的url地址
     * @param $stateValue
     * @return mixed
     */
    public function getSubAuthUrlByState($stateValue)
    {
        $subAuth = new SubAuth();
        return $subAuth->where('state_value', $stateValue)->first()->sub_auth_url;
    }

    /**
     * 查询映射列表
     * @param int $start 查询开始的的偏移量
     * @param int $limit 想要获取的数量
     * @return mixed
     */
    public function getTokenTransferMapList($start, $limit)
    {
        $subAuthORM = new SubAuth();
        return array(
            'rows' => $subAuthORM->skip($start)->take($limit)->get()->toArray(),
            'total' => $subAuthORM->count()
        );
    }

    /**
     * 添加一个token转发映射
     * @param $params
     */
    public function appendTokenTransferMap($params)
    {
        $this->setSubAuthUrl($params['sub_auth_url']);
        $this->setEnable($params['enable']);
        $this->setSiteName($params['site_name']);
        if (key_exists('state_value', $params)) {
            $this->setStateValue($params['state_value']);
        }
        $doneRow = $this->addSubAuthDone();
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData($doneRow);
    }

    /**
     * 修改token转发映射
     * @param $params
     */
    public function modifyTokenTransferMap($params)
    {
        foreach ($params as $rowItem) {
            $this->setId($rowItem['id']);
            $this->setSubAuthUrl($rowItem['sub_auth_url']);
            $this->setEnable($rowItem['enable']);
            $this->setSiteName($rowItem['site_name']);
            $this->setStateValue($rowItem['state_value']);
            $this->updateSubAuthDone();
        }
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData('');
    }

    /**
     * 删除token转发映射
     * @param $params
     */
    public function deleteTokenTransferMap($params)
    {
        $id = explode(',', $params['id']);
        $this->deleteSubAuth($id);
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
        IDXResponse::setBodyData('');
    }

}