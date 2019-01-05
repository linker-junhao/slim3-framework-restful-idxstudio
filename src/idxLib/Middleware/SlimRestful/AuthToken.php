<?php
/* 一个业务逻辑token类
 * File: AuthToken.phpeated: Monday, 10th December 2018 12:55:56 am
 * Author: Linker (linker-junhao@outlook.com)
 * -----
 * Last Modified: Monday, 10th December 2018 12:57:42 am
 * Modified By: Linker (linker-junhao@outlook.com)
 * -----
 * Copyright 2018 - 2018 Linker, IDX STUDIO
 * 
 * 授权一个token并记录在数据库中
 */

namespace IdxLib\Middleware\SlimRestful;

use IdxLib\Middleware\SlimRestful\Model\Token;


class AuthToken
{
    private $container;//slim容器
    private $uid;//该token所属的uid
    private $token;//token值
    private $privilege;//权限
    private $role;//角色
    private $allowed_resource;//允许访问的接口
    private $expire_time;//过期时间

    /**
     * AuthToken constructor.构建类
     * @param \Slim\Container $container
     */
    public function __construct(\Slim\Container $container)
    {
        Util\SlimRestfulDatabase::restfulEloquentConnectionReady($container);

        $this->allowed_resource = array();

        $this->container = $container;
    }

    /**
     * 返回token的相关信息
     * @return array
     */
    public function tokenInformation(){
        return array(
            'uid'   => $this->uid,
            'token' => $this->token,
            'privilege' => $this->privilege,
            'role'      => $this->role,
            'allowed_resource'  => $this->allowed_resource,
            'expire_time'       => $this->expire_time
        );
    }

    /**
     * 添加一个授权到数据库，完成后返回该授权的信息
     * @return array
     */
    public function tokenAuthDone()
    {
        if($this->token == null){
            $this->token = uniqid('auth', true);
        }
        if($this->privilege == null){
            $this->privilege = 1;
        }
        if($this->expire_time == null){
            $this->expire_time = date('Y-m-d H:i:s',time()+24*60*60);
        }
        $token = new Token();
        $token->uid = $this->uid;
        $token->token = $this->token;
        $token->privilege = $this->privilege;
        $token->role = $this->role;
        $token->allowed_resource = json_encode($this->allowed_resource);
        $token->expire_time = $this->expire_time;
        $token->save();
        return $this->tokenInformation();
    }

    /**
     * 为要添加的授权设置uid
     * @param string $uid
     * @return $this
     */
    public function setUid(string $uid)
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * 为授权设置token值
     * @param string $token
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * 为授权设置权限值 TODO 还没有相关作用
     * @param string $privilege
     * @return $this
     */
    public function setPrivilege(string $privilege)
    {
        $this->privilege = $privilege;
        return $this;
    }

    /**
     * 为授权设置一个角色值
     * @param string $role
     * @return $this
     */
    public function setRole(string $role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * 添加该授权可访问的资源api
     * @param string $resourceRoutePattern 添加的api的路由pattern
     * @param array $allowMethods 访问该路由pattern的方法
     * @return $this
     */
    public function addAllowedResource(string $resourceRoutePattern, array $allowMethods)
    {
        $this->allowed_resource[$resourceRoutePattern] = $allowMethods;
        return $this;
    }

    /**
     * 移除一个已添加的授权资源api的路由pattern
     * @param string $resourceRoutePattern
     */
    public function removeAllowedResource(string $resourceRoutePattern){
        if(key_exists($resourceRoutePattern, $this->allowed_resource)){
            unset($this->allowed_resource[$resourceRoutePattern]);
        }
    }

    /**
     * 替换某个资源api的可访问方法，如果原来未添加过会添加
     * @param string $resourceRoutePattern
     * @param array $allowMethods
     * @return $this
     */
    public function replaceAllowedResourceMethods(string $resourceRoutePattern, array $allowMethods)
    {
        if (key_exists($resourceRoutePattern, $this->allowed_resource)) {
            $this->allowed_resource[$resourceRoutePattern] = $allowMethods;
        } else {
            $this->addAllowedResource($resourceRoutePattern, $allowMethods);
        }
        return $this;
    }

    /**
     * 手动设置任意过期时间
     * @param string $expireDateTime
     * @return $this
     */
    public function setExpireTime(string $expireDateTime)
    {
        $this->expire_time = $expireDateTime;
        return $this;
    }

    /**
     * 在当前时间点基础上设置过期时间
     * @param int $expireDelayHours
     * @return $this
     */
    public function setExpireDelayHours(int $expireDelayHours){
        $this->expire_time = date('Y-m-d H:i:s',time()+$expireDelayHours*60*60);
        return $this;
    }
}

