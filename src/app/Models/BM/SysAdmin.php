<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/6
 * Time : 14:04
 */

namespace App\Models\BM;

use App\Models\ORM\TableYibanCrxToolboxAdmin;
use IdxLib\Middleware\SlimRestful\AuthToken;
use IdxLib\Standard\HttpResponse\IDXResponse;

class SysAdmin extends AbstractBM
{

    public function login($container, $bodyParams)
    {
        if ($this->checkPass($bodyParams['user_name'], $bodyParams['password'])) {
            $auth = new AuthToken($container);
            $tblAdmin = new TableYibanCrxToolboxAdmin();
            $adminRow = $tblAdmin->where('user_name', $bodyParams['user_name'])->where('password', $bodyParams['password'])->first();
            $auth->setUid($adminRow->id);
            $auth->setPrivilege('1');
            $auth->setRole('1');
            $auth->addAllowedResource('/token_transfer/state_url_map', array('get', 'post', 'put', 'delete'));
            $auth->addAllowedResource('/yiban/reset_pass', array('get', 'post', 'put', 'delete'));
            $token = $auth->tokenAuthDone();
            IDXResponse::setBodyCode(200);
            IDXResponse::setHttpStatusCode(200);
            IDXResponse::setBodyData($token);
            IDXResponse::setBodyStatus(true);
        }
    }

    private function checkPass($userName, $password)
    {
        $tblAdmin = new TableYibanCrxToolboxAdmin();
        if ($tblAdmin->where('user_name', $userName)->exists()) {
            //存在用户名
            if ($tblAdmin->where('user_name', $userName)->where('password', $password)->exists()) {
                //用户名密码正确，添加token授权
                return true;
            } else {
                //用户名存在，密码错误
                IDXResponse::setBodyErr('密码错误');
                IDXResponse::setBodyStatus(false);
                IDXResponse::setHttpStatusCode(200);
                IDXResponse::setBodyCode(200);
                return false;
            }
        } else {
            //不存在用户名
            IDXResponse::setBodyErr('该用户名不存在');
            IDXResponse::setBodyStatus(false);
            IDXResponse::setHttpStatusCode(200);
            IDXResponse::setBodyCode(200);
            return false;
        }
    }
}