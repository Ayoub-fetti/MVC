<?php
// Cette classe Controller est la classe parent que tous vos contrôleurs devront extends. 

namespace App\Core;
class Controller{

    // Cette fonction permet d'afficher les vues (views) de votre application Elle prend deux paramètres :
    // $view : le nom de la vue à afficher (sans l'extension .php)
    // $data : un tableau de données (optionnel) à passer à la vue
    // La fonction fait deux choses principales : Elle extrait les données du tableau $data en variables utilisables dans la vue
    // Elle vérifie si le fichier de vue existe dans ../app/views/ et l'inclut
    // example : $this->render('home/index', ['title' => 'Accueil']);

    protected function render($view, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

        $viewFile = "../app/views/" . $view . ".php";
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            throw new \Exception("View {$view} not found");
        }
    }

    // Cette fonction permet de récupérer les données envoyées en POST (formulaires)
    // Elle prend un paramètre optionnel $key
    // Comportement : Si $key est fourni : retourne la valeur de cette clé spécifique du POST ,Si $key n'est pas fourni : retourne tout le tableau $_POST
    // example : $nom = $this->getPost('nom'); // Récupère $_POST['nom'] 
    //           $allData = $this->getPost();  // Récupère tout $_POST
    protected function getPost($key = null)
    {
        if ($key) {
            return isset($_POST[$key]) ? $_POST[$key] : null;
        }
        return $_POST;
    }

    // Cette fonction permet de récupérer les données de l'URL (paramètres GET)
    // Fonctionne de la même manière que getPost() mais pour les données GET
    // example : $id = $this->getQuery('id');    // Récupère $_GET['id']
    //           $allParams = $this->getQuery(); // Récupère tout $_GET
    protected function getQuery($key = null)
    {
        if ($key) {
            return isset($_GET[$key]) ? $_GET[$key] : null;
        }
        return $_GET;
    }

    // Cette fonction permet de rediriger l'utilisateur vers une autre page
    // Elle prend un paramètre $url qui est l'URL de destination
    // Elle utilise la fonction header() de PHP pour effectuer la redirection
    // Le exit() assure que le script s'arrête après la redirection
    // example : $this->redirect('/home');  // Redirige vers la page d'accueil
    protected function redirect($url)
    {
        header("Location: " . $url);
        exit();
    }
}