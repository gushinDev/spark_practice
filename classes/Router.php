<?php

class Router
{
  private $uri = '';
  private $path = [];
  const ID_INDEX = 1;

  public function __construct($url)
  {
    $this->uri = trim($url, '/');
    $this->uri = parse_url($this->uri)['path'];
    $this->path = explode('/', $this->uri);

    switch (true) {
      case preg_match('/^users$/', $this->uri):
        $this->includeHandlerAndView('users', 'users_handler');
        break;

      case preg_match('/^users\/create$/', $this->uri):
        $this->includeHandlerAndView('users_create', 'users_create_handler');
        break;

      case preg_match('/^users\/\d*\/update$/', $this->uri):
        $_GET['user_id'] = $this->path[self::ID_INDEX];
        $this->includeHandlerAndView('users_update', 'users_update_handler');
        break;

      case preg_match('/^profile$/', $this->uri) || $this->uri == '':
        $this->includeHandlerAndView('profile', 'profile_handler');
        break;

      case preg_match('/^login$/', $this->uri):
        $this->includeHandlerAndView('login', 'login_handler');
        break;

      case preg_match('/^login\/logout$/', $this->uri):
        $_GET['logout'] = $this->path[self::ID_INDEX];
        $this->includeHandlerAndView('login', 'login_handler');
        break;

      case preg_match('/^registration$/', $this->uri):
        $this->includeHandlerAndView('registration', 'registration_handler');
        break;

      case preg_match("/^users\/\d*\/change_password$/", $this->uri):
        $path = explode('/', $this->uri);
        $_GET['user_id'] = $path[self::ID_INDEX];
        $this->includeHandlerAndView('users_change_password', 'users_change_password_handler');
        break;

      case preg_match("/^courses$/", $this->uri):
        $this->includeHandlerAndView('courses/courses', 'courses_handler');
        break;

      case preg_match("/^courses\/create$/", $this->uri):
        $this->includeHandlerAndView('courses/course_create', 'courses_create_handler');
        break;

      case preg_match("/^courses\/\d*\/delete$/", $this->uri):
        $path = explode('/', $this->uri);
        $_GET['course_id'] = $path[self::ID_INDEX];
        $this->includeHandlerAndView('courses/course_delete', 'courses_delete_handler');
        break;

      default :
        http_response_code(404);
        $this->includeHandlerAndView('404');
        break;
    }
  }

  private function includeHandlerAndView($view, $handler = null): void
  {
    if (isset($handler)) {
      include "../handlers/$handler.php";
    }
    include "../views/$view.php";
  }
}