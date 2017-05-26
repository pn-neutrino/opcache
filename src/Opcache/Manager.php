<?php

namespace Neutrino\Opcache;

/**
 * Class Manager
 *
 * @package Neutrino\Opcache
 */
class Manager
{
    private static $available;

    public function available()
    {
        if (!isset(self::$available)) {
            self::$available = extension_loaded('Zend Opcache')
                && (ini_get('opcache.enable') === '1' || ini_get('opcache.enable_cli') === '1');
        }

        return self::$available;
    }

    /**
     * Resets the contents of the opcode cache
     *
     * @return bool
     * TRUE : if the opcode cache was reset
     * FALSE : if the opcode cache is disabled.
     */
    public function reset()
    {
        return self::available() && opcache_reset();
    }

    /**
     * Invalidates a cached script
     *
     * @param string $file
     * @param bool   $force [optional] If set to TRUE, the script will be invalidated regardless of whether invalidation is necessary.
     *
     * @return bool
     */
    public function invalidate($file, $force = false)
    {
        return  self::available() && opcache_invalidate($file, $force);
    }

    /**
     * Compiles and caches a PHP script without executing it
     *
     * @param string $file
     *
     * @return bool
     */
    public function compile($file)
    {
        return self::available() && opcache_compile_file($file);
    }

    /**
     * This function checks if a PHP script has been cached in OPCache.
     * This can be used to more easily detect the "warming" of the cache for a particular script.
     *
     * @param string $file
     *
     * @return bool
     */
    public function isCached($file)
    {
        return self::available() && opcache_is_script_cached($file);
    }

    /**
     * Get status information about the cache
     *
     * @param bool $withScript Include script specific state information
     *
     * @return array
     */
    public function status($withScript = true)
    {
        if (self::available()) {
            return opcache_get_status($withScript);
        }

        return [];
    }

    /**
     * Get configuration information about the cache
     *
     * @return array
     */
    public function configuration()
    {
        if (self::available()) {
            return opcache_get_configuration();
        }

        return [];
    }
}