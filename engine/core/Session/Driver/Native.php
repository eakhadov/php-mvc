<?php
namespace Engine\Core\Session\Driver;

use Engine\Core\Config\Config;
use Engine\Core\Session\SessionDriver;
use Engine\Core\Session\SessionInterface;

class Native extends SessionDriver implements SessionInterface
{
    /**
     * @var array Flash data to keep for the next request.
     */
    protected array $keep = [];

    /**
     * {@inheritdoc}
     */
    public function initialize(): bool
    {
        $config = Config::group('session');

        if (!headers_sent()) {
            session_set_cookie_params([
                'lifetime' => $config['lifetime'],
                'path'     => $config['path'],
                'domain'   => $config['domain'],
                'secure'   => $config['secure'],
                'httponly' => $config['httponly'],
                'samesite' => $config['samesite'],
            ]);
            session_save_path($config['files']);
            session_name($config['cookie']);
            session_start();
        }

        if (!isset($_SESSION[$this->key])) {
            $_SESSION[$this->key] = [];
        }

        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function finalize(): bool
    {
        foreach (array_keys($this->kept()) as $name) {
            if (!in_array($name, $this->keep, true)) {
                unset($_SESSION['flash'][$name]);
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $name, $data): SessionDriver
    {
        $_SESSION[$this->key][$name] = $data;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $name)
    {
        return $_SESSION[$this->key][$name] ?? false;
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $name): bool
    {
        return isset($_SESSION[$this->key][$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $name): SessionDriver
    {
        if ($this->has($name)) {
            unset($_SESSION[$this->key][$name]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush(): SessionDriver
    {
        $_SESSION[$this->key] = [];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return $_SESSION[$this->key] ?? [];
    }

    /**
     * {@inheritdoc}
     */
    public function flash(string $name, $data = null)
    {
        if (null === $data) {
            return $_SESSION['flash'][$name] ?? false;
        } else {
            $this->keep($name);

            return $_SESSION['flash'][$name] = $data;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function keep(string $name): SessionDriver
    {
        if (!in_array($name, $this->keep, true)) {
            array_push($this->keep, $name);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function kept()
    {
        return $this->keep;
    }
}
