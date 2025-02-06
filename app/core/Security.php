<?php

namespace App\core;

class Security
{
    // Prevent XSS (Cross-Site Scripting) attacks by sanitizing input.
    public static function sanitizeXSS($input)
    {
        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    // Generate a CSRF token and store it in the session.
    public static function generateCSRFToken()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token = bin2hex(random_bytes(32)); // Generate a secure token with 64 characters , Convert binary data into hexadecimal 
        $_SESSION['csrf_token'] = $token; // Store the token in the session

        return $token;
    }

    // Validate a CSRF token.
    public static function validateCSRFToken($token)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            unset($_SESSION['csrf_token']); // Clear the token after validation
            return true;
        }

        return false;
    }

   
    // Prevent SQL Injection by using prepared statements.
    // This is a wrapper for PDO to make it easier to use.

    public static function preventSQLInjection($pdo, $sql, $params = [])
    {
        $stmt = $pdo->prepare($sql); // Prepare the SQL statement
        foreach ($params as $key => $value) {
            // Bind (lier) parameters securely
            $stmt->bindValue($key, $value, is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
        }
        $stmt->execute(); // Execute the statement
        return $stmt;
    }

    // Sanitize an array of inputs (e.g., $_POST or $_GET) to prevent XSS.
    public static function sanitizeArrayXSS($inputs)
    {
        $sanitized = [];
        foreach ($inputs as $key => $value) {
            $sanitized[$key] = self::sanitizeXSS($value);
        }
        return $sanitized;
    }


    // Generate a secure random string for use in tokens or passwords.
    public static function generateRandomString($length = 32)
    {
        return bin2hex(random_bytes($length));
    }
}