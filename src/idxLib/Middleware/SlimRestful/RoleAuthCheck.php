<?php
/**
 * 检查角色资源访问的权限
 */

namespace IdxLib\Middleware\SlimRestful;

use IdxLib\Middleware\SlimRestful\Util\HandlerSetIDXResponseErr;
use Slim\Exception\ContainerException;


class RoleAuthCheck
{
    private $container;
    private $roleArgumentName;

    /**
     * reveive the container object when class object build
     * @param \Slim\Container $c
     * @param $roleArgumentName
     */
    public function __construct(\Slim\Container $c, $roleArgumentName = 'role')
    {
        $this->container = $c;
        $this->roleArgumentName = $roleArgumentName;
    }

    /**
     * restful Middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface $response PSR7 response
     * @param  callable $next Next Middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __invoke($request, $response, $next)
    {
        //使用restful缓存
        $restfulCache = $this->container->get('slimRestfulCache');
        //取出在缓存中的本次请求的携带的token的相关信息
        $tokenCollection = $restfulCache->getDefaultCache('tokenCollection');
        //检查是否存在相关信息
        if($tokenCollection != false){
            if($request->getAttribute('route')->getArgument($this->roleArgumentName) != $tokenCollection->first()->role){
                HandlerSetIDXResponseErr::setErr403();
            } else {
                $response = $next($request, $response);
            }
        }else{
            HandlerSetIDXResponseErr::setErr500();
        }

        return $response;
    }
}