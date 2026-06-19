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

        $action = $this->getRouteAction($method, $uri);

        if (!$action) {
            http_response_code(404);

            throw new \Exception('Page Not Found');
        }

        [$controller, $method, $params] = $action;

        if (!empty($params)) {
            (new $controller())->{$method}(...$params);
        } else {
            (new $controller())->{$method}();
        }
    }

    private function getRouteAction(string $method, string $uri): ?array
    {
        if (isset($this->routes[$method][$uri])) {
            return [$this->routes[$method][$uri][0], $this->routes[$method][$uri][1], []];
        }

        foreach ($this->routes[$method] as $route => $action) {
            $routePattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
            $routePattern = '#^' . $routePattern . '$#';

            if (preg_match($routePattern, $uri, $matches)) {
                array_shift($matches);
                return [$action[0], $action[1], $matches];
            }
        }

        return null;
    }
}
