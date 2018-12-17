<?php
/**
 * 检查角色资源访问的权限
 */
 
namespace Middleware\SlimRestful;

use Slim\Exception\ContainerException;


class SlimRestfulRoleAuthCheck
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
     * restful middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface $response PSR7 response
     * @param  callable $next Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __invoke($request, $response, $next)
    {
        $restfulCache = $this->container->get('slimRestfulCache');
        $tokenCollection = $restfulCache->getDefaultCache('tokenCollection');
        if($tokenCollection != false){
            if($request->getAttribute('route')->getArgument($this->roleArgumentName) != $tokenCollection->first()->role){
                return $response->write("you can't access this resource")->withStatus(403);
            }
        }else{
            throw new Exception("Error Processing Request", 1);
        }

        $response = $next($request, $response);
        
        //after

        return $response;
    }
}