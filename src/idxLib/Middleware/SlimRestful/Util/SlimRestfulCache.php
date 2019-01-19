<?php
/**
 * 被实例化后的对象存储到了slim container中
 */

namespace IdxLib\Middleware\SlimRestful\Util;

class SlimRestfulCache
{
    private static $defaultCache = array('tokenCollection' => false);
    private static $myCache = array();

    public function __construct()
    {

    }

    /**
     * 获取默认缓存
     * @param string $cacheName
     * @return bool|mixed
     */
    public static function getDefaultCache(string $cacheName)
    {
        if (array_key_exists($cacheName, self::$defaultCache)) {
            return self::$defaultCache[$cacheName];
        } else {
            return false;
        }
    }

    /**
     * 设置到默认缓存
     * @param string $cacheName
     * @param $cacheValue
     */
    public static function setDefaultCache(string $cacheName, $cacheValue)
    {
        self::$defaultCache[$cacheName] = $cacheValue;
    }

    /**
     * 获取用户缓存
     * @param string $cacheName
     * @return bool|mixed
     */
    public static function getMyCache(string $cacheName)
    {
        return array_key_exists($cacheName, self::$myCache) ? self::$myCache[$cacheName] : false;
    }

    /**
     * 设置用户缓存
     * @param string $cacheName
     * @param $cacheValue
     */
    public static function setMyCache(string $cacheName, $cacheValue)
    {
        self::$myCache[$cacheName] = $cacheValue;
    }
}
