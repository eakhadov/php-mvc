<?php

namespace Engine\Core\Router;

use Engine\Core\Http\Request;
use Engine\Core\Http\Uri;

class Router
{
    private static $patterns = [
        'int' => '/^[0-9]+$/',
        'str' => '/^[a-zA-Z\.\-_%]+$/',
        'any' => '/^[a-zA-Z0-9\.\-_%]+$/',
    ];

    public static function initialize()
    {
        static::routes();
        $route = Repository::retrieve(Request::method(), Uri::segmentString());

        if (empty($route)) {
            exit('404');
        }

        $module = new Module($route);
        $module->run();

        // \DI::instance()->set('module', $module);
    }

    /**
     * Load the application routes.
     *
     * @return void
     */
    private static function routes(): void
    {
        foreach (scandir(path('modules')) as $module) {
            if (in_array($module, ['.', '..'], true)) {
                continue;
            }

            Route::$module = $module;

            if (is_file($path = path('modules') . '/' . $module . '/routes.php')) {
                require_once $path;
            }
        }

        static::rewrite();
    }

    /**
     * Rewrites the application routes.
     *
     * @return void
     */
    private static function rewrite(): void
    {
        foreach (Repository::stored() as $method => $routes) {
            foreach ($routes as $uri => $options) {
                $segments = explode('/', $uri);
                $rewrite  = false;

                foreach ($segments as $key => $segment) {
                    preg_match('/\(([0-9a-z]+)\:([a-z]+)\)/i', $segment, $matches);

                    if (!empty($matches)) {

                        $valid = false;
                        $var   = $matches[1];
                        $rule  = $matches[2];
                        $value = Uri::segment($key);

                        if (isset(static::$patterns[$rule]) && preg_match(static::$patterns[$rule], $value)) {
                            $valid = true;
                        }

                        if (true === $valid) {
                            $segments[$key]              = $value;
                            $options['parameters'][$var] = $value;
                        }

                        $rewrite = true;
                    } else if (Uri::segment($key) != $segments[$key]) {
                        break;
                    }
                }

                if ($rewrite) {
                    Repository::remove($method, $uri);
                    Repository::store($method, implode('/', $segments), $options);
                }
            }
        }
    }
}
