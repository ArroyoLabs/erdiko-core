<?php
/**
 * Cache
 * Dependency injected cache API 
 * 
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author	   John Arroyo
 */
namespace erdiko\core;


class Cache
{
    private static $instance = array();
    //private static $instanceMemcache;

    public static function getCacheObject($cacheConfig = 'default')
    {
            //Check if the caller requests an new object
            if (empty(self::$instance[$cacheConfig])) {

                $config = \Erdiko::getConfig('application/default');

                //Check if the object already be created
                if(isset($config["cache"][$cacheConfig]))
                    self::$instance[$cacheConfig] = new $config["cache"][$cacheConfig]['class'];
                else
                    throw new \Exception("There is no cache config defined ({$cacheConfig})");
            }

        return self::$instance[$cacheConfig];

    }

    /**
     * Get the value stored at the given key
     *
     * @param string $key
     */
    public static function get($key, $cacheConfig = 'default')
    {
        return self::getCacheObject($cacheConfig)->get($key);
    }

    /**
     * Put the supplied value into the given key
     *
     * @param string $key
     * @param mixed $value
     */
    public static function put($key, $value, $cacheConfig = 'default')
    {
        return self::getCacheObject($cacheConfig)->put($key, $value);
    }
    
    /**
     *
     * @param string $key
     */
    public static function has($key, $cacheConfig = 'default')
    {
        return self::getCacheObject($cacheConfig)->has($key);
    }

    /**
     * retrieve the cache value and then delete it before returning that value
     * @param string $key
     */
    public static function pull($key, $cacheConfig = 'default')
    {
        $value = self::get($key);
        self::forget($key);

        return $value;
    }

    /**
     * Remove an item from the cache
     * @param string $key
     */
    public static function forget($key, $cacheConfig = 'default')
    {
        return self::getCacheObject($cacheConfig)->forget($key);
    }

    /**
     * Forget all cache keys (Purge)
     */
    public static function forgetAll($cacheConfig = 'default')
    {
        return self::getCacheObject($cacheConfig)->forgetAll();
    }

}