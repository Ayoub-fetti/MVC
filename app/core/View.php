<?php

namespace App\Core;

class View
{
    protected function getBaseUrl()
    {
        return '';
    }

    protected function redirect($url)
    {
        $baseUrl = $this->getBaseUrl();
        // Remove leading slash from $url if it exists
        $url = ltrim($url, '/');
        header("Location: " . $baseUrl . '/' . $url);
        exit();
    }

    protected function render($view, $data = [])
    {
        extract($data);
        
        $viewFile = dirname(__DIR__) . "/views/{$view}.php";
        
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            throw new \Exception("View {$view} not found");
        }
    }
}