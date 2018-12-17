<?php
/**
 * Created by PhpStorm.
 * User: Linker
 * Date: 2018/12/15
 * Time: 16:07
 */

namespace App\Models\BM;


use App\Models\BM\Util\CurlRequest;
use App\Models\ORM\SubAuthApps;

class authTokenTransfer
{
    /**
     * 返回一个transfer适用的数组
     * @return array
     */
    public function transferArray()
    {
        return array(
            'state_value' => null,
            'sub_auth_url' => null,
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
     * @param $stateValue
     * @return $this
     */
    public function setStateValue($stateValue)
    {
        $this->transfer['state_value'] = $stateValue;
        return $this;
    }

    /**
     * 设置state-目标url映射的url值
     * @param $subAuthUrl
     * @return $this
     */
    public function setSubAuthUrl($subAuthUrl)
    {
        $this->transfer['sub_auth_url'] = $subAuthUrl;
        return $this;
    }

    /**
     * 设置该映射的启用/禁用状态
     * @param $enableFlag
     * @return $this
     */
    public function setEnable($enableFlag)
    {
        $this->transfer['enable'] = $enableFlag;
        return $this;
    }

    /**
     * 将该映射存储到数据库中
     */
    public function addSubAuthDone()
    {
        if ($this->transfer['state_value'] == null) {
            $this->transfer['state_value'] = uniqid('sa');
        }
        $subAuth = new SubAuthApps();
        foreach ($this->transfer as $colName => $val) {
            $subAuth->$colName = $val;
        }
        $subAuth->save();
    }

    /**
     * 删除对应主键id的映射关系
     * @param array | int $id
     */
    public function deleteSubAuth($id)
    {
        $subAuth = new SubAuthApps();
        $subAuth::destroy($id);
    }

    public function modifySubAuth()
    {

    }

    /**
     * 通过state值获取其映射到的url地址
     * @param $stateValue
     * @return mixed
     */
    public function getSubAuthUrlByState($stateValue)
    {
        $subAuth = new SubAuthApps();
        return $subAuth->where('state_value', $stateValue)->first()->sub_auth_url;
    }

    public function getYibanAccessTokenByCode($code, $client_id, $client_secret, $redirect_uri)
    {
        $url = 'https://openapi.yiban.cn/oauth/access_token';
        $token = CurlRequest::_httpPost($url, array(
                'code' => $code,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri' => $redirect_uri)
        );

        $tokenObj = json_decode($token);

        return $tokenObj;
    }
}