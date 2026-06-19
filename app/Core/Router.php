<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $uri, array $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, array $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

        if ($basePath !== '' && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        if ($uri === '') {
            $uri = '/';
        }

        $action = $this->routes[$method][$uri] ?? null;

        if (!$action) {
            http_response_code(404);

            throw new \Exception('Page Not Found');
        }

        [$controller, $method] = $action;

        (new $controller())->{$method}();
    }
}
