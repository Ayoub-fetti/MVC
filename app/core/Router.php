<?php

namespace App\Core;

class Router{
    private array $routes = [];
    private array $params = [];

    // Convert the route to a regular expression (principale)
    public function add(string $route, array $params = []): void
    {
        // Convert the route to a regular expression pattern
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^}]+)\}/', '(?P<\1>\2)', $route);
        $route = '#^' . $route . '$#i';
        
        $this->routes[$route] = $params;
    }
    
    // Match the route to the routes in the routing table (principale)
    public function match(string $url): bool
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        
        // Parse the URL to remove domain, port, and base path
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'] ?? '';
        
        // Remove base URL if present
        $baseUrl = '/MVC';
        if (strpos($path, $baseUrl) === 0) {
            $path = substr($path, strlen($baseUrl));
        }
        
        // Ensure path starts with /
        if (empty($path)) {
            $path = '/';
        } elseif ($path[0] !== '/') {
            $path = '/' . $path;
        }

        // Debug output
        error_log("Matching URL: " . $path);
        error_log("Request Method: " . $requestMethod);
        
        foreach ($this->routes as $route => $params) {
            error_log("Checking route: " . $route . " with params: " . print_r($params, true));
            
            if (preg_match($route, $path, $matches)) {
                error_log("Route matched!");
                // Check if method matches
                if (isset($params['method']) && $params['method'] !== $requestMethod) {
                    error_log("Method mismatch: expected " . $params['method'] . " got " . $requestMethod);
                    continue;
                }
                
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        error_log("No route matched for path: " . $path);
        return false;
    }


    // Get the currently matched parameters
    public function getParams(): array
    {
        return $this->params;
    }

    // Add GET route
    public function get(string $route, string $handler): void
    {
        $params = $this->parseHandler($handler);
        $params['method'] = 'GET';
        $this->add($route, $params);
    }

    // Add POST route
    public function post(string $route, string $handler): void
    {
        $params = $this->parseHandler($handler);
        $params['method'] = 'POST';
        $this->add($route, $params);
    }

    // Parse controller@action handler string
    private function parseHandler(string $handler): array
    {
        [$controller, $action] = explode('@', $handler);
        return [
            'controller' => $controller,
            'action' => $action
        ];
    }

    // Dispatch the route to the controller (principale)
    public function dispatch(string $url): void
    {
        error_log("Dispatching URL: " . $url);
        $url = $this->removeQueryStringVariables($url);
        error_log("URL after removing query string: " . $url);

        if ($this->match($url)) {
            error_log("Route matched! Controller: " . $this->getControllerName());
            $controller = $this->getControllerName();
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);
                $action = $this->getActionName();
                
                if (method_exists($controller_object, $action)) {
                    $controller_object->$action();
                } else {
                    throw new \Exception("Method $action in controller $controller not found");
                }
            } else {
                throw new \Exception("Controller class $controller not found");
            }
        } else {
            error_log("Available routes: " . print_r($this->routes, true));
            throw new \Exception('No route matched.', 404);
        }
    }

   
    //Get the controller name from the parameters
    private function getControllerName(): string
    {
        $controller = $this->params['controller'] ?? '';
        return $this->formatControllerName($controller);
    }

   
    // Format the controller name to follow PSR-4 naming convention
    private function formatControllerName(string $controller): string
    {
        // If controller already ends with 'Controller', don't add it again
        if (str_ends_with($controller, 'Controller')) {
            return str_replace('-', '', ucwords($controller, '-'));
        }
        return str_replace('-', '', ucwords($controller, '-')) . 'Controller';
    }

    
    // Get the action name from the parameters
    private function getActionName(): string
    {
        $action = $this->params['action'] ?? '';
        return lcfirst(str_replace('-', '', ucwords($action, '-')));
    }

   

     // Get the namespace for the controller class
    private function getNamespace(): string
    {
        return 'App\Controllers\\';
    }

   
    // Remove query string variables from the URL
    private function removeQueryStringVariables(string $url): string
    {
        if ($url !== '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }
}