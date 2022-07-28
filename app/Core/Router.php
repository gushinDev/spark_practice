<?php

namespace app\Core;

class Router
{
    private array|string $url;
    private array $routes = [];

    public function __construct($url)
    {
        $this->initRoutes();
        $this->prepareUrl($url);

        [$action, $params] = $this->findRouteMatches();
        [$controller, $actionName] = $this->parseActionForUrl($action);

        $this->initControllerAndAction($controller, $actionName, $params);
    }

    private function initRoutes(): void
    {
        require_once '../app/Config/routes.php';
        $this->routes = $routes;
    }

    private function prepareUrl($url): void
    {
        if (!empty($_SERVER['QUERY_STRING'])) {
            [$url, $getParams] = explode('?', $url);
        }
        $this->url = filter_var(trim($url, '/'), FILTER_SANITIZE_URL);
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

    private function initControllerAndAction($controller, $actionName, $params): void
    {
        $controllerObj = new $controller($actionName);
        $controllerObj->$actionName($params ? $params : []);
    }

    private function parseActionForUrl(string $action): array
    {
        [$controllerName, $actionName] = explode('@', $action);
        include '../' . $controllerName . '.php';
        $controller = '\\' . str_replace('/', '\\', $controllerName);
        return [$controller, $actionName];
    }

}

