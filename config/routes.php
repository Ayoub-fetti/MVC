<?php


//  Configuration des routes de app
//  Format: 'url' => ['controller' => 'NomController', 'action' => 'nomAction']
 

$router = new \App\Core\Router();

// Route par defaut (page d'accueil)
$router->add('/', [
    'controller' => 'Home',
    'action' => 'index'
]);

return $router;