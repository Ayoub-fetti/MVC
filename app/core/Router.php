<?php

namespace App\Core;

class Router
{
    /**
     * @var array Stores all registered routes
     */
    private array $routes = [];

    /**
     * @var array Stores the current route parameters
     */
    private array $params = [];

    /**
     * Add a route to the routing table
     *
     * @param string $route  The route URL
     * @param array  $params Parameters (controller, action, etc.)
     *
     * @return void
     */
    public function add(string $route, array $params = []): void
    {
        // Convert the route to a regular expression
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Match the route to the routes in the routing table
     *
     * @param string $url The route URL
     *
     * @return boolean True if a match is found, false otherwise
     */
    public function match(string $url): bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Get the currently matched parameters
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Dispatch the route to the controller
     *
     * @param string $url The route URL
     *
     * @return void
     * @throws \Exception
     */
    public function dispatch(string $url): void
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
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
            throw new \Exception('No route matched.', 404);
        }
    }

    /**
     * Get the controller name from the parameters
     *
     * @return string
     */
    private function getControllerName(): string
    {
        $controller = $this->params['controller'] ?? '';
        return $this->formatControllerName($controller);
    }

    /**
     * Format the controller name to follow PSR-4 naming convention
     *
     * @param string $controller
     * @return string
     */
    private function formatControllerName(string $controller): string
    {
        return str_replace('-', '', ucwords($controller, '-')) . 'Controller';
    }

    /**
     * Get the action name from the parameters
     *
     * @return string
     */
    private function getActionName(): string
    {
        $action = $this->params['action'] ?? '';
        return lcfirst(str_replace('-', '', ucwords($action, '-')));
    }

    /**
     * Get the namespace for the controller class
     *
     * @return string
     */
    private function getNamespace(): string
    {
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }

    /**
     * Remove query string variables from the URL
     *
     * @param string $url The full URL
     *
     * @return string The URL without query string variables
     */
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