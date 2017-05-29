<?php

namespace Neutrino\Opcache;

/**
 * Class Manager
 *
 * @package Neutrino\Opcache
 */
class Manager
{
    /** @var bool */
    private static $available;

    /** @var bool */
    private static $enable;

    /**
     * Check if opcache extension is loaded.
     *
     * @return bool
     */
    public static function isAvailable()
    {
        if (!isset(self::$available)) {
            self::$available = extension_loaded('Zend Opcache');
        }

        return self::$available;
    }

    /**
     * Check if Opcache is available for the current context : [CGI/FPM/..] <> CLI
     *
     * @return bool
     */
    public static function isEnable()
    {
        if (!isset(self::$enable)) {
            self::$enable = self::isAvailable() && ini_get('opcache.enable') === '1' && (php_sapi_name() === 'cli' ? ini_get('opcache.enable_cli') === '1' : true);
        }

        return self::$enable;
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
        return self::isEnable() && opcache_reset();
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
        return self::isEnable() && opcache_invalidate($file, $force);
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
        return self::isEnable() && opcache_compile_file($file);
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
        return self::isEnable() && opcache_is_script_cached($file);
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
        return self::isEnable() ? opcache_get_status($withScript) : [];
    }

    /**
     * Get configuration information about the cache
     *
     * @return array
     */
    public function configuration()
    {
        return self::isAvailable() ? opcache_get_configuration() : [];
    }
}