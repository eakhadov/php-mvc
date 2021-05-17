<?php

namespace Engine\Core\Http;

class Request
{
    /**
     * Check if the request is a particular method.
     *
     * @param string $method The request method to check for.
     * @return bool
     */
    public static function is(string $method): bool
    {
        switch (strtolower($method)) {
            case 'https':
                return self::https();
            case 'ajax':
                return self::ajax();
            case 'cli':
                return self::cli();
            default:
                return self::method() === $method;
        }
    }

    /**
     * Get the current request method.
     *
     * @return string
     */
    public static function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    /**
     * Check if the request is over a https connection.
     *
     * @return bool
     */
    public static function https(): bool
    {
        return ($_SERVER['HTTPS'] ?? '') === 'on';
    }

    /**
     * Check if the request is an AJAX request.
     *
     * @return bool
     */
    public static function ajax(): bool
    {
        return ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';
    }

    /**
     * Check if the request is a CLI request.
     *
     * @return bool
     */
    public static function cli(): bool
    {
        return (PHP_SAPI === 'cli' || defined('STDIN'));
    }
}
