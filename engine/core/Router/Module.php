<?php

namespace Engine\Core\Router;

class Module
{
    /**
     * @var string active module
     */
    public string $module = '';

    /**
     * @var array Module Information
     */
    public array $current = [];

    /**
     * @var string The active action.
     */
    public string $action = '';

    /**
     * @var array The active parameters.
     */
    public array $parameters = [];

    /**
     * @var string The active controller.
     */
    public string $controller = '';

    /**
     * Module constructor
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }

        $this->current = $this->current();
    }

    /**
     * Starting the module
     *
     * @return mixed
     */
    public function run()
    {
        $class = '\\Modules\\' . $this->module . '\Controller\\' . $this->controller;

        if (class_exists($class)) {
            call_user_func_array([new $class, $this->action], $this->parameters);
        } else {
            throw new \Exception(sprintf("Controller <strong>%s</strong> does not exist.", $class));
        }
    }

    /**
     * Load module information
     *
     * @return array
     */
    public function current(): array
    {
        $path = path('modules') . '/' . $this->module . '/' . 'module.json';

        return (is_file($path)) ? json_decode(file_get_contents($path), true) : [];
    }
}
