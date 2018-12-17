<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2018/12/16
 * Time : 0:18
 */

namespace App\Models\BM\Util;


class CurlRequest
{
    static function _httpGet($url = "")
    {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, false);//SET get
        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    static function _httpPost($url = "", $requestData = array())
    {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);//SET POST
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //普通数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestData));
        $res = curl_exec($curl);

        curl_close($curl);
        return $res;
    }

}