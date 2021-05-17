<?php

namespace Engine\Core\Template;

class Component
{
    /**
     * @var \Twig\Environment
     */
    public static $twig;

    /**
     * @param $twig
     */
    public static function setTwig(\Twig\Environment $twig)
    {
        static::$twig = $twig;
    }

    /**
     * Gets a component.
     *
     * @param $template The component.
     * @param array $data The component data.
     * @return string
     */
    public static function get($template, array $data = []): string
    {
        return $template->render($data);
    }

    /**
     * Loads a view component.
     *
     * @param string $file The file to the component.
     * @return Twig\TemplateWrapper
     */
    public static function load(string $file): \Twig\TemplateWrapper
    {
        return static::$twig->load($file . '.twig');
    }

}
