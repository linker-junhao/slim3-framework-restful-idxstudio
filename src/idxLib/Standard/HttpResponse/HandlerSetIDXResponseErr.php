<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/5
 * Time : 18:47
 */

namespace IdxLib\Standard\HttpResponse;


class HandlerSetIDXResponseErr
{
    public static function setStatus200()
    {
        IDXResponse::setBodyCode(200);
        IDXResponse::setHttpStatusCode(200);
        IDXResponse::setBodyStatus(true);
    }

    public static function setStatus400()
    {
        IDXResponse::setBodyData(array(
            'message' => "malformed request, no Authorization header"
        ));
        IDXResponse::setBodyCode(400);
        IDXResponse::setHttpStatusCode(400);
        IDXResponse::setBodyStatus(false);
        IDXResponse::setBodyErr('malformed request, no Authorization header');
    }

    public static function setStatus401()
    {
        IDXResponse::setBodyData(array(
            'message' => "unAuthorized"
        ));
        IDXResponse::setBodyCode(401);
        IDXResponse::setHttpStatusCode(401);
        IDXResponse::setBodyStatus(false);
        IDXResponse::setBodyErr('unAuthorized');
    }

    public static function setStatus403()
    {
        IDXResponse::setBodyData(array(
            'message' => "you do not have permission to access this resource"
        ));
        IDXResponse::setBodyCode(403);
        IDXResponse::setHttpStatusCode(403);
        IDXResponse::setBodyStatus(false);
        IDXResponse::setBodyErr('you do not have permission to access this resource');

    }

    public static function setStatus500()
    {
        IDXResponse::setBodyData(array(
            'message' => "Internal Server Error"
        ));
        IDXResponse::setBodyCode(500);
        IDXResponse::setHttpStatusCode(500);
        IDXResponse::setBodyStatus(false);
        IDXResponse::setBodyErr('Internal Server Error');
    }
}