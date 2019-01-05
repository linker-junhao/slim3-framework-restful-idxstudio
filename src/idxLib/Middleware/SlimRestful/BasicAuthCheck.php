<?php
/* 基于slim的授权保证restful api框架
 * 目标：
 * 1. 能够进行安全验证，使用登陆后产生的临时token
 * 2. 能够记录调用api的时间点和IP地址和其它相关信息
 * 3. 可配置接受何种请求方式
 * 4. 重写
 * 5. 日志记录
 * 方案：
 * 1. 建立一张token记录表，然后用户登陆后插入一条随机token的记录并记录时间
 *    后续每次调用api都查验相应请求携带的token是否在该表内，并检测该token是否过期
 *    可以使用数据库实现或者使用redis实现
 * 问题：
 * 1. 保证登陆后的持续使用，间隔一定的时间段不使用才将该授权的token过期
 * 2. 统一错误处理如何实现，错误需要记录日志
 */
/**
 * 1.请求进入时判断是否符合允许的方式
 * 2.token在header Authorization内
 * 3.api版本号在header Accept内
 * 4.根据不同的资源状态，返回不同的http status code
 *
 * 资源分为：公共资源、私人资源、角色资源；
 * 公共资源指开放访问的资源，该资源不用授权，可以直接在代码中取消该访问的中间件，分为登陆即可访问或无需登陆即可访问
 * 私人资源指仅可以由个人访问到的资源，该资源访问时需要鉴权，并判定该权限是否是该资源所有人的
 * 角色资源指的是属于某一角色群体的资源，比如管理员角色，可以对其角色内的资源进行访问
 *
 * 授权时将授权的接口名写入到数据表的allow_resource字段下，以json格式存储
 * 1.访问资源时首先判断token是否存在且未过期
 * 2.token合法，检查该token被赋予权限的接口名，如果访问的该资源存在于其中，即可正常访问。
 */

namespace IdxLib\Middleware\SlimRestful;

use IdxLib\Middleware\SlimRestful\Util\HandlerSetIDXResponseErr;

class BasicAuthCheck
{
    private $container;
    private $authHeaderName;

    /**
     * reveive the container object when class object build
     * @param \Slim\Container $container
     * @param string $authHeaderName
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(\Slim\Container $container, string $authHeaderName = 'Authorization')
    {
        //配置determineRouteBeforeAppMiddleware为true
        $container->get('settings')->replace(array('determineRouteBeforeAppMiddleware' => true));
        //define error handler
        $this->errorHandlerDefine();
        //register a cache service，将缓存对象保存到slim 容器中
        $container['slimRestfulCache'] = function ($container) {
            return new Util\SlimRestfulCache();
        };
        //ready database 
        Util\SlimRestfulDatabase::restfulEloquentConnectionReady($container);
        $this->container = $container;
        $this->authHeaderName = $authHeaderName;
    }

    /**
     * load custom error handler into container
     *
     * @return void
     */
    private function errorHandlerDefine()
    {
        // $this->container['notFoundHandler'] = function ($c) {
        //     return new Handler\RestfulNotFound();
        // };
    }


    /**
     * check the request is legal
     *
     * @param string $token
     * @return bool
     * @throws \Interop\Container\Exception\ContainerException
     */
    private function checkTokenAuth(string $token)
    {
        $tokenModel = new Model\Token();
        $tokenCollection = $tokenModel->where('token', $token)->get();
        //检查数据库中有没有该token，判断该请求是否被授权
        if ($tokenCollection->count() == 0) {
            //没有该授权token的相关信息
            return false;
        }
        //缓存查询到的token
        $this->container->get('slimRestfulCache')->setDefaultCache('tokenCollection', $tokenCollection);
        $token = $tokenCollection->first();
        //数据库中有该token，对比过期时间与当前时间
        if (strtotime($token->expire_time) < strtotime(date("Y-m-d h:i:s"))) {
            //过期
            return false;
        } else {
            return true;
        }
    }

    private function checkResourceAuthorized($route)
    {
        $allowedResources = json_decode($this->container->get('slimRestfulCache')->getDefaultCache('tokenCollection')->first()->allowed_resource, true);
        $routePattern = $route->getPattern();
        return key_exists($routePattern, $allowedResources) ? in_array(strtolower($route->getMethods()[0]), $allowedResources[$routePattern]) : false;
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
        $authHeaderArray = $request->getHeader('Authorization');
        if (count($authHeaderArray) == 0) {
            //check essential header if exist 检查该请求是否有token
            HandlerSetIDXResponseErr::setErr400();
        } elseif (!$this->checkTokenAuth($request->getHeader($this->authHeaderName)[0])) {
            //check token authorized 检查该请求token是否合法
            HandlerSetIDXResponseErr::setErr401();
        } elseif (!$this->checkResourceAuthorized($request->getAttribute('route'))) {
            //check resource authorized to the token 检查资源是否被授予该token
            HandlerSetIDXResponseErr::setErr403();
        } else {
            //can be access by this token 基本检查确认可以访问该资源
            $response = $next($request, $response);
        }
        return $response;
    }
}