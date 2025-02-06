<?php

$router = new \App\Core\Router();

// Route par defaut (page d'accueil)
$router->add('/', [
    'controller' => 'Front\Home',
    'action' => 'index'
]);

// Routes bach ntester 
$router->add('/test', [
    'controller' => 'Back\Test',
    'action' => 'indexTest'
]);

$router->add('/hello', [
    'controller' => 'Back\Test',
    'action' => 'hello'
]);

$router->add('/params', [
    'controller' => 'Back\Test',
    'action' => 'params'
]);

// Routes bach ntester CRUD
$router->add('/create', [
    'controller' => 'Back\Test',
    'action' => 'testCreate'
]);

$router->add('/read', [
    'controller' => 'Back\Test',
    'action' => 'testRead'
]);

$router->add('/update', [
    'controller' => 'Back\Test',
    'action' => 'testUpdate'
]);

$router->add('/delete', [
    'controller' => 'Back\Test',
    'action' => 'testDelete'
]);

$router->add('/all', [
    'controller' => 'Back\Test',
    'action' => 'testAll'
]);

return $router;