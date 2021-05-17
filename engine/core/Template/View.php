<?php

namespace Engine\Core\Template;

use Engine\Core\Facades\Session;
use Engine\Core\Helper\Cookie;
use Engine\Core\HTTP\Input;

class View
{
    /**
     * @var string
     */
    protected string $file = '';

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var string
     */
    protected static string $theme = '';

    public function __construct()
    {
        $themePath  = content_path('themes') . '/' . static::$theme;
        $themeCache = server_path('cache') . '/' . static::$theme;

        $loader = new \Twig\Loader\FilesystemLoader($themePath);

        $this->twig = new \Twig\Environment($loader, [
            'cache'       => $themeCache,
            'auto_reload' => true,
        ]);

        $this->twig->addGlobal('_session', Session::all());
        $this->twig->addGlobal('_cookie', Cookie::all());
        $this->twig->addGlobal('_post', Input::post());
        $this->twig->addGlobal('_get', Input::get());
        $this->twig->addGlobal('_server', $_SERVER);

        $this->twig->addExtension(new Extension\AssetExtension());
    }

    /**
     * Returns the view data.
     *
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Render the view.
     *
     * @return string
     */
    public function render(): string
    {
        $template = $this->twig->load($this->file . '.twig');

        return $template->render($this->data);
    }

    public static function theme($theme = ''): string
    {
        if ('' !== $theme) {
            static::$theme = $theme;
        }

        return static::$theme;
    }

    /**
     * Instantiates the view.
     *
     * @param string $file
     * @param array $data
     * @return Engine\Core\Template\View
     */
    public static function make(string $file, array $data = []): View
    {
        $name        = get_called_class();
        $class       = new $name();
        $class->file = $file;
        $class->data = $data;

        return $class;
    }
}
