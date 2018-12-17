<?php
/* 
 * 检查私人资源访问权限
 */

namespace Middleware\SlimRestful;

use Exception;

class SlimRestfulPrivateAuthCheck
{
    private $container;
    private $UIDArgumentName;

    /**
     * reveive the container object when class object build
     * @param \Slim\Container $container
     * @param string $UIDArgumentName
     */
    public function __construct(\Slim\Container $container, string $UIDArgumentName = 'uid')
    {
        $this->container = $container;
        $this->UIDArgumentName = $UIDArgumentName;
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
            if($request->getAttribute('route')->getArgument($this->UIDArgumentName) != $tokenCollection->first()->uid){
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