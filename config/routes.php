<?php

$router = new \App\Core\Router();

// default route
$router->get('/', 'HomeController@index');

// Authentication routes
$router->get('/login', 'AuthController@login');
$router->post('/handllogin', 'AuthController@handllogin');

$router->get('/register', 'AuthController@register');
$router->post('/handlregister', 'AuthController@handlregister');

$router->get('/logout', 'AuthController@logout');

// Dashboard routes
$router->get('/dashboard', 'DashboardController@index');

// Admin routes
$router->get('/admin/dashboard', 'DashboardController@index');
$router->get('/admin/users', 'AdminController@users');
$router->get('/admin/permissions', 'AdminController@permissions');
$router->post('/admin/permissions', 'AdminController@permissions');

return $router;