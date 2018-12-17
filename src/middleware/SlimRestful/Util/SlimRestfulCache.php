<?php
namespace Middleware\SlimRestful\Util;

class SlimRestfulCache
{
    private $defaultCache;
    private $myCache;
    public function __construct()
    {
        $this->defaultCache = array('tokenCollection' => false);
        $this->myCache = array();
    }

    public function getDefaultCache(string $cacheName)
    {
        if (array_key_exists($cacheName, $this->defaultCache)) {
            return $this->defaultCache[$cacheName];
        } else {
            return false;
        }
    }

    public function setDefaultCache(string $cacheName, $cacheValue)
    {
        $this->defaultCache[$cacheName] = $cacheValue;
    }

    public function getMyCache(string $cacheName)
    {
        return array_key_exists($cacheName, $this->myCache) ? $this->myCache[$cacheName] : false;
    }

    public function setMyCache(string $cacheName, $cacheValue)
    {
        $this->myCache[$cacheName] = $cacheValue;
    }
}
