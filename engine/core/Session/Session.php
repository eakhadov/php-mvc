<?php

namespace Engine\Core\Session;

use Engine\Core\Config\Config;

class Session
{
    /**
     * @var bool Session initialized.
     */
    protected static bool $initialized = false;

    /**
     * @var SessionDriver The active session driver.
     */
    protected static $driver;

    /**
     * Create new session.
     *
     * @return void
     */
    public function __construct()
    {
        if (!static::$initialized) {

            $class          = 'Engine\\Core\\Session\\Driver\\' . ucfirst(strtolower(Config::item('driver', 'session')));
            static::$driver = new $class;

            if (static::$driver->initialize()) {
                static::$initialized = true;
            }
        }
    }

    /**
     * Destroys the session.
     *
     * @return void
     */
    public function __destruct()
    {
        static::$driver->finalize();
    }

    /**
     * Gets the active session driver.
     *
     * @return SessionDriver
     */
    public static function driver(): SessionDriver
    {
        return static::$driver;
    }

}
