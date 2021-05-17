<?php

namespace Engine;

class Container
{
    /**
     * @var Container
     */
    protected static $instance = null;

    /**
     * Dependency container.
     *
     * @var array
     */
    private array $container = [];

    /**
     * Get dependency from the container.
     *
     * @param $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return ($this->has($key)) ? $this->container[$key] : null;
    }

    /**
     * Add dependency to container.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function set(string $key, $value): object
    {
        $this->container[$key] = $value;

        return $this;
    }

    /**
     * See if there is a dependency in the container.
     *
     * @param $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->container[$key]);
    }

    /**
     * Undocumented function
     *
     * @return Container
     */
    public static function instance(): Container
    {
        if (null == self::$instance) {
            self::$instance = new Container();
        }
        return self::$instance;
    }
}
