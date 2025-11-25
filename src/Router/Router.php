<?php

namespace App\Router;

class Router {
    private array $routes = [];

    public function get(string $path, callable $callback): void {
        $this->addRoute('GET', $path, $callback);
    }

    public function post(string $path, callable $callback): void {
        $this->addRoute('POST', $path, $callback);
    }

    private function addRoute(string $method, string $path, callable $callback): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function run(): void {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];

        // Supprimer les query strings
        $requestUri = strtok($requestUri, '?');

        // Supprimer le trailing slash sauf pour la racine
        if ($requestUri !== '/' && str_ends_with($requestUri, '/')) {
            $requestUri = rtrim($requestUri, '/');
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                call_user_func($route['callback']);
                return;
            }
        }

        // Route non trouvée
        http_response_code(404);
        echo '<h1>404 - Page not found</h1>';
    }
}
