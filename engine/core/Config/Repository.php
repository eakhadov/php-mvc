<?php

namespace Engine\Core\Config;

class Repository
{
    /**
     * @var array Stored config items.
     */
    protected static array $stored = [];

    /**
     * Stores a config item.
     *
     * @param string $group The item group.
     * @param string $key The item key.
     * @param mixed  $data The item data.
     * @return void
     */
    public static function store(string $group, string $key, $data): void
    {
        if (!isset(static::$stored[$group]) || !is_array(static::$stored[$group])) {
            static::$stored[$group] = [];
        }

        static::$stored[$group][$key] = $data;
    }

    /**
     * Retrieves a config item.
     *
     * @param string $group The item group.
     * @param string $key The item key.
     * @return mixed
     */
    public static function retrieve(string $group, string $key)
    {
        return (static::$stored[$group][$key]) ?? false;
    }

    /**
     * Retrieves a config group.
     *
     * @param string $group The item group.
     * @return mixed
     */
    public static function retrieveGroup(string $group)
    {
        return (static::$stored[$group]) ?? false;
    }
}
