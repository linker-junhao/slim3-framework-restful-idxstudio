<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2018/12/29
 * Time : 14:43
 */

namespace IdxLib\Middleware\SlimRestful;


class RequestAndResponse
{
    public function __construct()
    {

    }

    /**
     * restful Middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface $response PSR7 response
     * @param  callable $next Next Middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $response = $next($request, $response);

        //TODO 判断请求的数据类型json/xml，并做出相应数据格式的回应，目前仅json
        $response = $response
            ->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');;
        $response->getBody()->write(Standard\HttpResponse\IDXResponse::bodyToJson());

        return $response->withStatus(Standard\HttpResponse\IDXResponse::$httpStatusCode);
    }
}