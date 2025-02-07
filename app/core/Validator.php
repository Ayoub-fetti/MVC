<?php

namespace App\Core;

 // Classe Validator pour la validation des données utilisateur
 // Cette classe permet de valider les données d'entrée selon des règles définies
class Validator{
    public array $errors = [];
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
     // Méthode principale de validation
     // Format: ['champ' => 'regle1|regle2:parametre']
     // Exemple: ['email' => 'required|email', 'age' => 'required|numeric']
    public function validate(array $rules): bool
    {
        foreach ($rules as $field => $fieldRules) {
            // Sépare les règles multiples (ex: 'required|email' devient ['required', 'email'])
            $fieldRules = explode('|', $fieldRules);
            
            foreach ($fieldRules as $rule) {
                // Vérifie si la règle a un paramètre (ex: 'min:8')
                if (strpos($rule, ':') !== false) {
                    [$ruleName, $parameter] = explode(':', $rule);
                } else {
                    $ruleName = $rule;
                    $parameter = null;
                }

                // Construit le nom de la méthode de validation (ex: validateRequired)
                $methodName = 'validate' . ucfirst($ruleName);
                if (method_exists($this, $methodName)) {
                    // Appelle la méthode de validation correspondante
                    if (!$this->$methodName($field, $parameter)) {
                        break; // Arrête la validation de ce champ si une règle échoue
                    }
                }
            }
        }

        // Retourne true si aucune erreur n'a été trouvée
        return empty($this->errors);
    }

    // Récupère les erreurs de validation
    public function getErrors(): array
    {
        return $this->errors;
    }


    // Valide si un champ est requis (non vide)
    public function validateRequired(string $field): bool
    {
        $value = $this->data[$field] ?? '';
        // Vérifie si le champ est vide (mais accepte '0' comme valeur valide)
        if (empty($value) && $value !== '0') {
            $this->errors[$field][] = "Le champ {$field} est obligatoire.";
            return false;
        }
        return true;
    }


     // Valide si un champ est une adresse email valide
    public function validateEmail(string $field): bool
    {
        // Skip la validation si le champ est vide (sauf si required est utilisé)
        if (!isset($this->data[$field]) || empty($this->data[$field])) {
            return true;
        }

        // Utilise le filtre PHP intégré pour valider l'email
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "Le champ {$field} doit être une adresse email valide.";
            return false;
        }
        return true;
    }


     // Valide la longueur minimale d'un champ
    public function validateMin(string $field, string $parameter): bool
    {
        if (!isset($this->data[$field]) || empty($this->data[$field])) {
            return true;
        }

        // Vérifie si la longueur est supérieure ou égale au minimum requis
        if (strlen($this->data[$field]) < (int)$parameter) {
            $this->errors[$field][] = "Le champ {$field} doit contenir au moins {$parameter} caractères.";
            return false;
        }
        return true;
    }


    // Valide la longueur maximale d'un champ
    public function validateMax(string $field, string $parameter): bool
    {
        if (!isset($this->data[$field]) || empty($this->data[$field])) {
            return true;
        }

        // Vérifie si la longueur ne dépasse pas le maximum autorisé
        if (strlen($this->data[$field]) > (int)$parameter) {
            $this->errors[$field][] = "Le champ {$field} ne doit pas dépasser {$parameter} caractères.";
            return false;
        }
        return true;
    }


    // Valide si un champ contient une valeur numérique
    public function validateNumeric(string $field): bool
    {
        if (!isset($this->data[$field]) || empty($this->data[$field])) {
            return true;
        }

        // Vérifie si la valeur est numérique
        if (!is_numeric($this->data[$field])) {
            $this->errors[$field][] = "Le champ {$field} doit être numérique.";
            return false;
        }
        return true;
    }


    // Valide si un champ contient uniquement des lettres

    public function validateAlpha(string $field): bool
    {
        if (!isset($this->data[$field]) || empty($this->data[$field])) {
            return true;
        }

        // Vérifie si la valeur contient uniquement des lettres
        if (!ctype_alpha($this->data[$field])) {
            $this->errors[$field][] = "Le champ {$field} ne doit contenir que des lettres.";
            return false;
        }
        return true;
    }


    // Valide si un champ contient uniquement des lettres et des chiffres
    public function validateAlphaNum(string $field): bool
    {
        if (!isset($this->data[$field]) || empty($this->data[$field])) {
            return true;
        }

        // Vérifie si la valeur contient uniquement des lettres et des chiffres
        if (!ctype_alnum($this->data[$field])) {
            $this->errors[$field][] = "Le champ {$field} ne doit contenir que des lettres et des chiffres.";
            return false;
        }
        return true;
    }
}