<?php

namespace Engine\Core\Facades;

use Engine\Core\Session\Session as Factory;
use Engine\Core\Session\SessionDriver;

class Session
{
    /**
     * Initializes the session.
     *
     * @return Engine\Core\Session\SessionDriver
     */
    public static function initialize()
    {
        return static::make();
    }

    /**
     * Finalizes the session.
     *
     * @return bool
     */
    public static function finalize(): bool
    {
        return static::make()->driver()->finalize();
    }

    /**
     * Inserts data into a session.
     *
     * @param string $name The name of the session.
     * @param mixed $data The data to add into the session.
     * @return Engine\Core\Session\SessionDriver
     */
    public static function set(string $name, $data): SessionDriver
    {
        return static::make()->driver()->set($name, $data);
    }

    /**
     * Gets data from a session.
     *
     * @param string $name The name of the session.
     * @return mixed
     */
    public static function get(string $name)
    {
        return static::make()->driver()->get($name);
    }

    /**
     * Checks if an item exists in session.
     *
     * @param string $name The name of the session.
     * @return bool
     */
    public static function has(string $name): bool
    {
        return static::make()->driver()->has($name);
    }

    /**
     * Deletes an item from session.
     *
     * @param string $name The name of the session.
     * @return Engine\Core\Session\SessionDriver
     */
    public static function delete(string $name): SessionDriver
    {
        return static::make()->driver()->delete($name);
    }

    /**
     * Deletes all items from the session.
     *
     * @return Engine\Core\Session\SessionDriver
     */
    public static function flush(): SessionDriver
    {
        return static::make()->driver()->flush();
    }

    /**
     * Returns all items in the session.
     *
     * @return array
     */
    public static function all(): array
    {
        return static::make()->driver()->all();
    }

    /**
     * Sets flash data that only lives for one request, if no data was passed
     * it will attempt to find the stored data.
     *
     * @param string $name The name of the flash data.
     * @param array $data The data to store in the session.
     * @return mixed
     */
    public static function flash(string $name, $data = null)
    {
        return static::make()->driver()->flash($name, $data);
    }

    /**
     * Keep flash data for another request.
     *
     * @param string $name The name of the data to keep.
     * @return Engine\Core\Session\SessionDriver
     */
    public static function keep(string $name): SessionDriver
    {
        return static::make()->driver()->keep($name);
    }

    /**
     * Returns the data kept for the next request.
     *
     * @return array
     */
    public static function kept(): array
    {
        return static::make()->driver()->kept();
    }

    /**
     * Instantiates a new instance of the session class.
     *
     * @return Engine\Core\Session\Session
     */
    public static function make(): \Engine\Core\Session\Session
    {
        return new Factory();
    }
}
