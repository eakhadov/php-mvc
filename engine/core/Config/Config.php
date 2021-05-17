<?php

namespace Engine\Core\Config;

class Config
{
    /**
     * Retrieves a config item.
     *
     * @param string $key The item key.
     * @param string $group The item group.
     * @return mixed
     */
    public static function item(string $key, string $group)
    {
        if (!Repository::retrieve($group, $key)) {
            self::file($group);
        }

        return Repository::retrieve($group, $key);
    }

    /**
     * Retrieves a group config items.
     *
     * @param string $group The item group.
     * @return mixed
     */
    public static function group(string $group)
    {
        if (!Repository::retrieveGroup($group)) {
            self::file($group);
        }

        return Repository::retrieveGroup($group);
    }

    /**
     * Loading the configuration file
     *
     * @param string $group The group name of the file
     * @return bool
     * @throws Exception
     */
    public static function file(string $group): bool
    {
        $path = path('config') . '/' . $group . '.php';

        if (file_exists($path)) {
            $items = include $path;

            if (is_array($items)) {
                foreach ($items as $key => $value) {
                    Repository::store($group, $key, $value);
                }

                return true;
            } else {
                throw new \Exception(sprintf('Config file <strong>%s</strong> is not a valid array.', $path));
            }
        } else {
            throw new \Exception(sprintf('Cannot load config from file, file <strong>%s</strong> does not exist.', $path));
        }

        return false;
    }
}
