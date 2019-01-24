<?php
/**
 * 检查角色资源访问的权限
 */

namespace IdxLib\Middleware\SlimRestful;

use IdxLib\Standard\HttpResponse\HandlerSetIDXResponseErr;
use IdxLib\Middleware\SlimRestful\Util\SlimRestfulCache;
use Psr\Container\ContainerInterface;
use Slim\Exception\ContainerException;


class RoleAuthCheck
{
    private $container;
    private $roleArgumentName;

    /**
     * receive the container object when class object build
     * @param ContainerInterface $c
     * @param string $roleArgumentName
     */
    public function __construct(ContainerInterface $c, $roleArgumentName = 'role')
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
     */
    public function __invoke($request, $response, $next)
    {
        //使用restful缓存
        //取出在缓存中的本次请求的携带的token的相关信息
        $tokenCollection = SlimRestfulCache::getDefaultCache('tokenCollection');
        //检查是否存在相关信息
        if($tokenCollection != false){
            if($request->getAttribute('route')->getArgument($this->roleArgumentName) != $tokenCollection->first()->role){
                HandlerSetIDXResponseErr::setStatus403();
            } else {
                $response = $next($request, $response);
            }
        }else{
            HandlerSetIDXResponseErr::setStatus500();
        }

        return $response;
    }
}