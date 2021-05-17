<?php

namespace Engine\Core\Router;

class Route
{
    /**
     * @var string Route prefix.
     */
    private static string $prefix = '';

    /**
     * @var string The module we're settings routes for.
     */
    public static string $module;

    /**
     * Sets a GET route.
     *
     * @param string $uri The URI to route.
     * @param array $options The route options.
     * @return bool
     */
    public static function get(string $uri, array $options): bool
    {
        return static::add('GET', $uri, $options);
    }

    /**
     * Sets a POST route.
     *
     * @param string $uri The URI to route.
     * @param array $options The route options.
     * @return bool
     */
    public static function post(string $uri, array $options): bool
    {
        return static::add('POST', $uri, $options);
    }

    /**
     * Sets a PUT route.
     *
     * @param string $uri The URI to route.
     * @param array $options The route options.
     * @return bool
     */
    public static function put(string $uri, array $options): bool
    {
        return static::add('PUT', $uri, $options);
    }

    /**
     * Sets a PATCH route.
     *
     * @param string $uri The URI to route.
     * @param array $options The route options.
     * @return bool
     */
    public static function patch(string $uri, array $options): bool
    {
        return static::add('PATCH', $uri, $options);
    }

    /**
     * Sets a DELETE route.
     *
     * @param string $uri The URI to route.
     * @param array $options The route options.
     * @return bool
     */
    public static function delete(string $uri, array $options): bool
    {
        return static::add('DELETE', $uri, $options);
    }

    /**
     * Sets a route.
     *
     * @param string $method The route method,
     * @param string $uri The URI to route.
     * @param array $options The route options.
     * @return bool
     */
    public static function add(string $method, string $uri, array $options): bool
    {
        if (static::validateOptions($options)) {
            if (!isset($options['module'])) {
                $options['module'] = static::$module;
            }

            Repository::store($method, static::prefixed($uri), $options);
            return true;
        }

        return false;
    }

    /**
     * Preprends the prefix to the URI.
     *
     * @param string $uri The URI to prefix.
     * @return string
     */
    public static function prefixed(string $uri): string
    {
        if (strpos($uri, '?')) {
            $uri = stristr($uri, '?', true);
        }

        $uri = trim($uri, '/');

        if (static::$prefix !== '' && static::$prefix !== '/') {
            $uri = trim(static::$prefix, '/') . '/' . $uri;
        }

        return trim($uri, '/');
    }

    /**
     * Validates the route options.
     *
     * @param array $options Route options to validate.
     * @return bool
     */
    private static function validateOptions(array $options): bool
    {
        return isset($options['controller'], $options['action']);
    }
}
