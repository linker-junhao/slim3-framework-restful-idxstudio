<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/6
 * Time : 14:36
 */

namespace App\Models\BM\Util;


class BMCache
{
    private static $cache = array();

    /**
     * @param string $cacheName
     * @param mixed $cacheVal
     */
    public static function setCache($cacheName, $cacheVal)
    {
        self::$cache[$cacheName] = $cacheVal;
    }

    /**
     * @param $cacheName
     * @return array
     * @throws \Exception
     */
    public static function getCache($cacheName)
    {
        try {
            return self::$cache[$cacheName];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}