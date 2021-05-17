<?php

namespace Engine\Core\Session;

class SessionDriver
{

    /**
     * @var string The session key name.
     */
    protected $key = 'engine';

    /**
     * Returns the array key used to store session data.
     *
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }
}