<?php

function path($section): string
{
    switch (strtolower($section)) {
        case 'config':
            return $_SERVER['DOCUMENT_ROOT'] . '/app/config';
        case 'data':
            return $_SERVER['DOCUMENT_ROOT'] . '/app/data';
        case 'modules':
            return $_SERVER['DOCUMENT_ROOT'] . '/modules';
        case 'content':
            return $_SERVER['DOCUMENT_ROOT'] . '/content';
        case 'server':
            return $_SERVER['DOCUMENT_ROOT'] . '/server';
        default:
            return $_SERVER['DOCUMENT_ROOT'] . '/';
    }
}

function content_path($section = ''): string
{
    switch (strtolower($section)) {
        case 'themes':
            return path('content') . '/themes';
        case 'plugins':
            return path('content') . '/plugins';
        case 'uploads':
            return path('content') . '/uploads';
        default:
            return path('content');
    }
}

function server_path($section = ''): string
{
    switch (strtolower($section)) {
        case 'logs':
            return path('server') . '/logs';
        case 'cache':
            return path('server') . '/cache';
        case 'sessions':
            return path('server') . '/sessions';
        default:
            return path('server');
    }
}

function get_modules(): array
{
    $modulesPath = path('modules');
    $list        = scandir($modulesPath);
    $modules     = [];

    if (!empty($list)) {
        foreach ($list as $dir) {
            if ('.' === $dir || '..' === $dir) {
                continue;
            }

            $pathModuleDir = $modulesPath . '/' . $dir;
            $pathConfig    = $pathModuleDir . '/module.json';

            if (is_dir($pathModuleDir) && is_file($pathConfig)) {

                $info         = json_decode(file_get_contents($pathConfig));
                $info->module = $dir;

                $modules[] = $info;
            }
        }
    }

    return $modules;
}

function get_themes(): array
{
    $themesPath = content_path('themes');
    $list       = scandir($themesPath);
    $themes     = [];

    if (!empty($list)) {
        foreach ($list as $dir) {
            if ('.' === $dir || '..' === $dir) {
                continue;
            }

            $pathThemeDir = $themesPath . '/' . $dir;
            $pathConfig   = $pathThemeDir . '/theme.json';
            $pathScreen   = '/content/themes/' . $dir . '/screen.jpg';

            if (is_dir($pathThemeDir) && is_file($pathConfig)) {

                $info         = json_decode(file_get_contents($pathConfig));
                $info->screen = $pathScreen;

                $themes[] = $info;
            }
        }
    }

    return $themes;
}

function env(string $key, $default = null)
{
    if (array_key_exists($key, $_ENV)) {

        switch ($_ENV[$key]) {
            case 'true':
                $_ENV[$key] = true;
                break;
            case 'false':
                $_ENV[$key] = false;
                break;
            case 'null':
                $_ENV[$key] = null;
                break;
        }
    } else {
        $_ENV[$key] = $default;
    }

    return $_ENV[$key];
}
