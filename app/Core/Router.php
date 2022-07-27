<?php

namespace app\Core;

class Router
{
    private array|string $url;
    private array $routes = [];

    public function __construct($url)
    {
        $this->initRoutes();
        $this->url = filter_var(trim($url, '/'), FILTER_SANITIZE_URL);
        [$action, $params] = $this->findRouteMatches();
        [$controller, $actionName] = $this->parseActionForUrl($action);
        $controllerObj = new $controller($actionName);
        $controllerObj->$actionName($params ? $params : []);
    }

    private function initRoutes(): void
    {
        require_once '../app/Core/routes.php';
        $this->routes = $routes;
    }

    public function findRouteMatches(): array
    {
        foreach ($this->routes as $route => $action) {
            if (preg_match('/^' . $route . '$/', $this->url, $params)) {
                array_shift($params);
                return [$action, $params];
            }
        }
        return ['app/Access/Controllers/AccessController@notFound', []];
    }


    private function parseActionForUrl(string $action): array
    {
        [$controllerName, $actionName] = explode('@', $action);
        include '../' . $controllerName . '.php';
        $controller = '\\' . str_replace('/', '\\', $controllerName);
        return [$controller, $actionName];
    }

}

