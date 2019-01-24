<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2018/12/29
 * Time : 15:56
 */

namespace IdxLib\Standard\HttpResponse;


class IDXResponse
{
    public static $bodyStatus = true;
    public static $bodyCode = 200;
    public static $bodyData = '';
    public static $bodyError = '';

    public static $httpStatusCode;

    /**
     * 以数组形式获取将要返回的body数据
     * @return array
     */
    public static function bodyToArray()
    {
        return array(
            'status' => self::$bodyStatus,
            'code' => self::$bodyCode,
            'data' => self::$bodyData,
            'error' => self::$bodyError
        );
    }

    /**
     * 设置body中status数据项的值
     * @param bool $status
     * @return string
     */
    public static function setBodyStatus(bool $status)
    {
        self::$bodyStatus = $status;
        return self::class;
    }

    /**
     * 设置body中code数据项的值
     * @param int $code
     * @return string
     */
    public static function setBodyCode(int $code)
    {
        self::$bodyCode = $code;
        return self::class;
    }

    /**
     * 设置body中data数据项的值
     * @param $data
     * @return string
     */
    public static function setBodyData($data)
    {
        self::$bodyData = $data;
        return self::class;
    }

    /**
     * 设置body中error数据项的值
     * @param $err
     * @return string
     */
    public static function setBodyErr($err)
    {
        self::$bodyError = $err;
        return self::class;
    }

    /**
     * json形式的body数据
     * @return false|string
     */
    public static function bodyToJson()
    {
        return json_encode(self::bodyToArray());
    }

    /**
     * xml形式的body数据
     */
    public static function bodyToXML()
    {
        //TODO complete xml
    }

    /**
     * 设置要返回的http status
     * @param int $statusCode
     * @return string
     */
    public static function setHttpStatusCode(int $statusCode)
    {
        self::$httpStatusCode = $statusCode;
        return self::class;
    }
}