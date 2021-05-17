<?php

namespace Engine\Core\Http;

class Uri
{
    /**
     * @var string The base URL.
     */
    protected static string $base = '';

    /**
     * @var string The active URI.
     */
    protected static string $uri = '';

    /**
     * @var array URI segments.
     */
    protected static array $segments = [];

    /**
     * Initialize the URI class.
     *
     * @return void
     */
    public static function initialize()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $host     = $_SERVER['HTTP_HOST'];
            $request  = $_SERVER['REQUEST_URI'];
            $protocol = 'http' . (Request::https() ? 's' : '');
            $base     = $protocol . '://' . $host;
            $uri      = $base . $request;

            $length   = strlen($base);
            $str      = (string) substr($uri, $length);
            $arr      = (array) explode('/', trim($str, '/'));
            $segments = [];

            foreach ($arr as $segment) {

                if ('' === $segment) {
                    continue;
                }

                if (strpos($segment, '?') !== false) {
                    $segment = stristr($segment, '?', true);

                    if ('' !== $segment) {
                        array_push($segments, $segment);
                    }

                    break;
                }

                array_push($segments, $segment);
            }

            static::$uri      = $uri;
            static::$base     = $base;
            static::$segments = $segments;
        } else if (isset($_SERVER['argv'])) {

            $segments = [];

            foreach ($_SERVER['argv'] as $arg) {

                if ($arg !== $_SERVER['SCRIPT_NAME']) {
                    array_push($segments, $arg);
                }
            }

            static::$segments = $segments;
        }
    }

    /**
     * Get the base URI.
     *
     * @return string
     */
    public static function base(): string
    {
        return static::$base;
    }

    /**
     * Get the current URI.
     *
     * @return string
     */
    public static function uri(): string
    {
        return static::$uri;
    }

    /**
     * Get the URI segments.
     *
     * @return array
     */
    public static function segments(): array
    {
        return static::$segments;
    }

    /**
     * Gets a segment from the URI.
     *
     * @param int $num The segment number.
     * @return string
     */
    public static function segment(int $num): string
    {
        return (static::$segments[$num]) ?? '';
    }

    /**
     * Get the URI segments as a string.
     *
     * @return string
     */
    public static function segmentString(): string
    {
        return implode('/', static::$segments);
    }
}
