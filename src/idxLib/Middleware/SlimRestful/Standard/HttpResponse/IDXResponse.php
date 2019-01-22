<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2018/12/29
 * Time : 15:56
 */

namespace IdxLib\Middleware\SlimRestful\Standard\HttpResponse;


class IDXResponse
{
    public static $bodyStatus = true;
    public static $bodyCode = 200;
    public static $bodyData = '';
    public static $bodyError = '';

    public static $httpStatusCode;

    public static function bodyToArray()
    {
        return array(
            'status' => self::$bodyStatus,
            'code' => self::$bodyCode,
            'data' => self::$bodyData,
            'error' => self::$bodyError
        );
    }

    public static function setBodyStatus(bool $status)
    {
        self::$bodyStatus = $status;
        return self::class;
    }

    public static function setBodyCode(int $code)
    {
        self::$bodyCode = $code;
        return self::class;
    }

    public static function setBodyData($data)
    {
        self::$bodyData = $data;
        return self::class;
    }

    public static function setBodyErr($err)
    {
        self::$bodyError = $err;
        return self::class;
    }

    public static function bodyToJson()
    {
        return json_encode(self::bodyToArray());
    }

    public static function bodyToXML()
    {
        //TODO complete xml
    }

    public static function setHttpStatusCode(int $statusCode)
    {
        self::$httpStatusCode = $statusCode;
        return self::class;
    }
}