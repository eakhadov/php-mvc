<?php

require_once __DIR__ . '/vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

if (version_compare(PHP_VERSION, \Engine\Define::PHP_MIN) == -1) {

    print_r('Работа сайта невозможна: Требуется PHP версия ' . \Engine\Define::PHP_MIN . " или выше.<br>");
    print_r('На данный момент установлена версия ' . PHP_VERSION);
    exit();
}

\Dotenv\Dotenv::createImmutable(__DIR__)->load();
\Engine\Engine::start();