<?php

namespace Engine;

use Engine\Core\Database\Database;
use Engine\Core\Facades\Session;
use Engine\Core\Http\Uri;
use Engine\Core\Router\Router;


class Engine
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public static function start(): void
    {
        Uri::initialize();
        Session::initialize();
        Database::initialize();

        Router::initialize();

        static::finish();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function finish(): void
    {
        Session::finalize();
        Database::finalize();
    }
}
