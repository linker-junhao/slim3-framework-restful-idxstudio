<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/5
 * Time : 18:47
 */

namespace IdxLib\Middleware\SlimRestful\Util;


use IdxLib\Middleware\SlimRestful\Standard\HttpResponse\IDXResponse;

class HandlerSetIDXResponseErr
{
    public static function setErr400()
    {
        IDXResponse::setBodyData(array(
            'message' => "malformed request, no Authorization header"
        ));
        IDXResponse::setBodyCode(400);
        IDXResponse::setHttpStatusCode(400);
        IDXResponse::setBodyStatus(false);
        IDXResponse::setBodyErr('malformed request, no Authorization header');
    }

    public static function setErr401()
    {
        IDXResponse::setBodyData(array(
            'message' => "unAuthorized"
        ));
        IDXResponse::setBodyCode(401);
        IDXResponse::setHttpStatusCode(401);
        IDXResponse::setBodyStatus(false);
        IDXResponse::setBodyErr('unAuthorized');
    }

    public static function setErr403()
    {
        IDXResponse::setBodyData(array(
            'message' => "you do not have permission to access this resource"
        ));
        IDXResponse::setBodyCode(403);
        IDXResponse::setHttpStatusCode(403);
        IDXResponse::setBodyStatus(false);
        IDXResponse::setBodyErr('you do not have permission to access this resource');

    }

    public static function setErr500()
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