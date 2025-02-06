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

return $router;