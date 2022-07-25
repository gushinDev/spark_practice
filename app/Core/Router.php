<?php

namespace app\Core;


class Router
{
    private array|string $url;
    private array $routes = [
      '' => 'app/Users/Controllers/UsersController@index',
      'users' => 'app/Users/Controllers/UsersController@index',
      'users\/(\d+)' => 'app/Users/Controllers/UsersController@findUser',
      'users\/create' => 'app/Users/Controllers/UsersController@createUser',
      'users\/(\d+)\/delete' => 'app/Users/Controllers/UsersController@deleteUser',
      'users\/(\d+)\/update' => 'app/Users/Controllers/UsersController@updateUser',
      'login' => 'app/Access/Controllers/AccessController@login',
      'registration' => 'app/Access/Controllers/AccessController@registration',
      'logout' => 'app/Access/Controllers/AccessController@logout',
      'profile' => 'app/Users/Controllers/UsersController@userProfile',
      'not_found' => 'app/Access/Controllers/AccessController@notFound',
      'courses' => 'app/Courses/Controllers/CoursesController@index',
      'courses\/(\d+)\/delete' => 'app/Courses/Controllers/CoursesController@deleteCourse',
      'courses\/create' => 'app/Courses/Controllers/CoursesController@createCourse',
      'courses\/(\d+)' => 'app/Courses/Controllers/CoursesController@readCourse',
      'courses\/(\d+)\/add_section' => 'app/Courses/Controllers/CoursesController@addSection',
      'courses\/(\d+)\/update' => 'app/Courses/Controllers/CoursesController@updateCourse',
    ];

    public function __construct($url)
    {
        $this->url = filter_var(trim($url, '/'), FILTER_SANITIZE_URL);
        [$action, $params] = $this->findRouteMatches();
        [$controller, $actionName] = $this->parseActionForUrl($action);
        $controllerObj = new $controller();
        if ($params) {
            $controllerObj->$actionName($params);
        } else {
            $controllerObj->$actionName();
        }
    }

    public function findRouteMatches(): array
    {
        foreach ($this->routes as $route => $action) {
            if (preg_match('/^' . $route . '$/', $this->url, $params)) {
                array_shift($params);
                return [$action, $params];
            }
        }
        return ['app/Users/Controllers/UsersController@index', []];
    }


    private function parseActionForUrl(string $action): array
    {
        [$controllerName, $actionName] = explode('@', $action);
        include '../' . $controllerName . '.php';
        $controller = '\\' . str_replace('/', '\\', $controllerName);
        return [$controller, $actionName];
    }

}