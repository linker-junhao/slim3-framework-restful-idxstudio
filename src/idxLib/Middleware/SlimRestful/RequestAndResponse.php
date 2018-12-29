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
    private static $responseStatus;
    private static $responseBodyData;

    public function __construct()
    {

    }

    /**
     * check the request method is allowed
     *
     * @param string $methodName
     * @return bool
     */
    private function checkMethodAllow(string $methodName)
    {
        $methodName = strtolower($methodName);
        $allowedMethods = array('get', 'post', 'put', 'delete', 'patch');
        return in_array($methodName, $allowedMethods);
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
        //check method
        if (!$this->checkMethodAllow($request->getMethod())) {
            return $response->write('{"message":"' . $request->getMethod() . 'method not allowed"}')->withStatus(405);
        }
        $response = $next($request, $response);
        $response->getBody()->write('AFTER');
        return $response;
    }
}