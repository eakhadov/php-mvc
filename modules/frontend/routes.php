<?php

use Engine\Core\Router\Route;

Route::get('/', [
    'controller' => 'HomeController',
    'action'     => 'index',
]);

Route::get('/stats', [
    'controller' => 'HomeController',
    'action'     => 'index',
]);

Route::get('/player/(id:int)', [
    'controller' => 'HomeController',
    'action'     => 'index',
]);

// Route::get('/shop/(id:int)/(ip:str)', [
//     'controller' => 'HomeController',
//     'action'     => 'index',
// ]);