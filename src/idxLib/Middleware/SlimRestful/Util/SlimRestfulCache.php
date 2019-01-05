<?php
/**
 * 被实例化后的对象存储到了slim container中
 */
namespace IdxLib\Middleware\SlimRestful\Util;

class SlimRestfulCache
{
    private $defaultCache;
    private $myCache;
    public function __construct()
    {
        $this->defaultCache = array('tokenCollection' => false);
        $this->myCache = array();
    }

    /**
     * 获取默认缓存
     * @param string $cacheName
     * @return bool|mixed
     */
    public function getDefaultCache(string $cacheName)
    {
        if (array_key_exists($cacheName, $this->defaultCache)) {
            return $this->defaultCache[$cacheName];
        } else {
            return false;
        }
    }

    /**
     * 设置到默认缓存
     * @param string $cacheName
     * @param $cacheValue
     */
    public function setDefaultCache(string $cacheName, $cacheValue)
    {
        $this->defaultCache[$cacheName] = $cacheValue;
    }

    /**
     * 获取用户缓存
     * @param string $cacheName
     * @return bool|mixed
     */
    public function getMyCache(string $cacheName)
    {
        return array_key_exists($cacheName, $this->myCache) ? $this->myCache[$cacheName] : false;
    }

    /**
     * 设置用户缓存
     * @param string $cacheName
     * @param $cacheValue
     */
    public function setMyCache(string $cacheName, $cacheValue)
    {
        $this->myCache[$cacheName] = $cacheValue;
    }
}
