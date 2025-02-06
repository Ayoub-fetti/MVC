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
$router->add('/test/create', [
    'controller' => 'Back\Test',
    'action' => 'testCreate'
]);

$router->add('/test/read', [
    'controller' => 'Back\Test',
    'action' => 'testRead'
]);

$router->add('/test/update', [
    'controller' => 'Back\Test',
    'action' => 'testUpdate'
]);

$router->add('/test/delete', [
    'controller' => 'Back\Test',
    'action' => 'testDelete'
]);

$router->add('/test/all', [
    'controller' => 'Back\Test',
    'action' => 'testAll'
]);

return $router;