<?php

namespace Engine\Core\Router;

class Repository
{
    /**
     * @var array Stored routes.
     */
    protected static array $stored = [
        'GET'    => [],
        'POST'   => [],
        'PUT'    => [],
        'PATCH'  => [],
        'DELETE' => [],
    ];

    /**
     * Retrieve the stored routes.
     *
     * @return array
     */
    public static function stored(): array
    {
        return static::$stored;
    }

    /**
     * Stores a new route.
     *
     * @param string $method The route request method.
     * @param string $uri The route URI.
     * @param array $options The route options.
     * @return void
     */
    public static function store(string $method, string $uri, array $options): void
    {
        static::$stored[$method][$uri] = $options;
    }

    /**
     * Retrieve a stored route.
     *
     * @param string $method The route method.
     * @param string $uri The route URI.
     * @return array
     */
    public static function retrieve(string $method, string $uri): array
    {
        return static::$stored[$method][$uri] ?? [];
    }

    /**
     * Remove a stored route.
     *
     * @param string $method The route method.
     * @param string $uri The route URI.
     * @return bool
     */
    public static function remove(string $method, string $uri): bool
    {
        if (isset(static::$stored[$method][$uri])) {
            unset(static::$stored[$method][$uri]);
            return true;
        }

        return false;
    }
}
