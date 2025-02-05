<?php


//  Configuration des routes de app
//  Format: 'url' => ['controller' => 'NomController', 'action' => 'nomAction']
 

$router = new \App\Core\Router();

// Route par defaut (page d'accueil)
$router->add('/', [
    'controller' => 'Home',
    'action' => 'index'
]);

// Routes de test
$router->add('/test', [
    'controller' => 'Back\Test',
    'action' => 'index'
]);

$router->add('/test/hello/{name}', [
    'controller' => 'Back\Test',
    'action' => 'hello'
]);

$router->add('/test/params', [
    'controller' => 'Back\Test',
    'action' => 'params'
]);

return $router;