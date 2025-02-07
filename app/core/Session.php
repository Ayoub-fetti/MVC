<?php

namespace App\Core;

class Session {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            // Configuration sécurisée des sessions
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_secure', 1);
            ini_set('session.cookie_httponly', 1);
            
            session_start();
        }
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function has($key) {
        return isset($_SESSION[$key]);
    }

    public function clear() {
        session_destroy();
        $_SESSION = [];
    }

    public function regenerate() {
        session_regenerate_id(true);
    }

    public function setFlash($key, $message) {
        $_SESSION['flash'][$key] = $message;
    }

    public function getFlash($key) {
        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        return null;
    }

    public function hasFlash($key) {
        return isset($_SESSION['flash'][$key]);
    }
}