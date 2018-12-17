<?php
/*
 * File: SlimRestfulAuthToken.php
 * File Created: Monday, 10th December 2018 12:55:56 am
 * Author: Linker (linker-junhao@outlook.com)
 * -----
 * Last Modified: Monday, 10th December 2018 12:57:42 am
 * Modified By: Linker (linker-junhao@outlook.com)
 * -----
 * Copyright 2018 - 2018 Linker, IDX STUDIO
 * 
 * 授权一个token并记录在数据库中
 */

namespace Middleware\SlimRestful;

use Middleware\SlimRestful\Model\Token;


class SlimRestfulAuthToken
{
    private $container;
    private $uid;
    private $token;
    private $privilege;
    private $role;
    private $allowed_resource;
    private $expire_time;

    public function __construct(\Slim\Container $container)
    {
        Util\SlimRestfulDatabase::restfulEloquentConnectionReady($container);

        $this->allowed_resource = array();

        $this->container = $container;
    }
    
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

    public function setUid(string $uid)
    {
        $this->uid = $uid;
        return $this;
    }

    public function setToken(string $token)
    {
        $this->token = $token;
        return $this;
    }

    public function setPrivilege(string $privilege)
    {
        $this->privilege = $privilege;
        return $this;
    }

    public function setRole(string $role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @param string $resourceRoutePattern
     * @param array $allowMethods
     * @return $this
     */
    public function addAllowedResource(string $resourceRoutePattern, array $allowMethods)
    {
        $this->allowed_resource[$resourceRoutePattern] = $allowMethods;
        return $this;
    }

    public function removeAllowedResource(string $resourceRoutePattern){
        if(key_exists($resourceRoutePattern, $this->allowed_resource)){
            unset($this->allowed_resource[$resourceRoutePattern]);
        }
    }

    public function replaceAllowedResourceMethods(string $resourceRoutePattern, array $allowMethods)
    {
        $this->allowed_resource[$resourceRoutePattern] = $allowMethods;
        return $this;
    }

    public function setExpireTime(string $expireDateTime)
    {
        $this->expire_time = $expireDateTime;
        return $this;
        
    }

    public function setExpireDelayHours(int $expireDelayHours){
        $this->expire_time = date('Y-m-d H:i:s',time()+$expireDelayHours*60*60);
        return $this;
    }
}

