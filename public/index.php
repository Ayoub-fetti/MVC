<?php
// errors display
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Charger l'autoloader
    require_once dirname(__DIR__) . '../app/core/Database.php';
    require_once dirname(__DIR__) . '/vendor/autoload.php';

    // Initialize Database

    // Charger les routes
    $router = require_once dirname(__DIR__) . '/config/routes.php';

    // Obtenir l'URL actuelle
    $url = $_SERVER['REQUEST_URI'];
    
    // Dispatcher la requête
    $router->dispatch($url);
    
} catch (Exception $e) {
    //
    echo "Erreur : " . $e->getMessage();
    echo "<br>Fichier : " . $e->getFile();
    echo "<br>Ligne : " . $e->getLine();
}
