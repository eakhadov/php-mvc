<?php

namespace Engine\Core\Helper;

class Cookie
{
    /**
     * Add cookies
     * 
     * @param string $key
     * @param mixed $value
     * @param int $time
     */
    public static function set(string $key, $value, array $options = [])
    {
        setcookie($key, $value, $options);
    }

    /**
     * Get cookies by key
     * 
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }
        return null;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function all()
    {
        return $_COOKIE ?? [];
    }

    /**
     * Delete cookies by key
     * 
     * @param string $key
     */
    public static function delete(string $key)
    {
        if (isset($_COOKIE[$key])) {
            static::set($key, '', ['expires' => -3600]);
            unset($_COOKIE[$key]);
        }
    }
}
