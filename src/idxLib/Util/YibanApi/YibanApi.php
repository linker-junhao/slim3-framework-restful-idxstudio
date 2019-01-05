<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/2
 * Time : 18:56
 */

namespace IdxLib\Util\YibanApi;


class YibanApi
{
    /**
     * 由授权的code获得accesstoken
     * @param $code
     * @param $client_id
     * @param $client_secret
     * @param $redirect_uri
     * @return mixed
     */
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