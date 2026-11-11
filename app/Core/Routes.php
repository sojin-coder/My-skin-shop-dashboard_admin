<?php

class Router {
    private $routes = [];

    public function get(string $path, array $action): void
    {
        $this->routes['GET'][$path] = [
            'action' => $action
        ];
    }

    public function post(string $path, array $action): void
    {
        $this->routes['POST'][$path] = [
            'action' => $action
        ];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));

        $baseDir = preg_replace('#/public$#', '', $scriptDir);

        if ($scriptDir !== '' && $scriptDir !== '/' && stripos($uri, $scriptDir) === 0) {
            $uri = substr($uri, strlen($scriptDir));
        } elseif ($baseDir !== '' && $baseDir !== '/' && stripos($uri, $baseDir) === 0) {
            $uri = substr($uri, strlen($baseDir));
        }

        $uri = '/' . trim($uri, '/');

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            echo '404 - page Not found';
            return;
        }

        $route = $this->routes[$method][$uri];

        [$controller, $methodName] = $route['action'];

        $controllerInstance = new $controller();

        $controllerInstance->$methodName();
    }
}

?>