<?php

/**
 * Configuration des routes de l'application
 * Format: 'url' => ['controller' => 'NomController', 'action' => 'nomAction']
 */

$router = new \App\Core\Router();

// Route par défaut (page d'accueil)
$router->add('/', [
    'controller' => 'Home',
    'action' => 'index'
]);

return $router;