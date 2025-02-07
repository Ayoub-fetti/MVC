<?php

namespace App\Core;

use App\Models\User;

class Auth {
    private $validator;
    private $session;

    public function __construct($data = []) {
        $this->validator = new Validator($data);
        $this->session = new Session();
    }

    public function register($data) {
        // Validation des données
        $errors = [];

      
        
        if (!$this->validator->validateEmail($data['email'])) {
            $errors['email'] = "Email invalide";
            var_dump($errors['email']);die();
            
        }
        
        if (!$this->validator->validateMin($data['password'], 6)) {
            $errors['password'] = "Le mot de passe doit contenir au moins 6 caractères";
        }
        
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        // Vérifier si l'email existe déjà
        if (User::where('email', $data['email'])->exists()) {
            return ['success' => false, 'errors' => ['email' => "Cet email existe déjà"]];
        }

        try {
            // Création de l'utilisateur avec Eloquent
            $user = new User();
            $user->email = $data['email'];
            $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
            $user->save();

            $this->session->setFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'errors' => ['general' => "Une erreur est survenue lors de l'inscription."]];
        }
    }

   
    public function login($email, $password) {
        
        $errors = [];
        
        // Validation de l'email
        if (!$this->validator->validateEmail($email)) {
            var_dump($email);die();
            $errors['email'] = "Email invalide";
           
        }
    
        // Recherche de l'utilisateur avec Eloquent
        $user = User::where('email', $email)->first();
    
        if (!$user || !password_verify($password, $user->password)) {
            $errors['password'] = "Email ou mot de passe incorrect";
        }
    
        // Vérifier s'il y a des erreurs et les retourner
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
    
        // Création de la session
        $this->session->set('user_id', $user->id);
        $this->session->set('user_email', $user->email);
    
        // Régénération de l'ID de session pour la sécurité
        $this->session->regenerate();
    
        return ['success' => true];
    }
    

    public function isLoggedIn() {
        return $this->session->has('user_id');
    }

    public function logout() {
        $this->session->clear();
        return true;
    }

    public function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }

        return User::find($this->session->get('user_id'));
    }

    public function hasPermission($permission)
    {
        if ($user = $this->getCurrentUser()) {
            return $user->hasPermission($permission);
        }
        return false;
    }

    public function getAllPermissions()
    {
        if ($user = $this->getCurrentUser()) {
            return $user->getAllPermissions();
        }
        return [];
    }
}