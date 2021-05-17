<?php

namespace Engine;

abstract class Controller
{
    /**
     * @var array The list of data
     */
    public array $data = [];

    /**
     * Adding data to the list
     *
     * @param string $key Data key
     * @param mixed $value Data value
     * @return void
     */
    public function setData(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Returning the class name
     *
     * @return string
     */
    public function getNameController(): string
    {
        return get_called_class();
    }
}
