<?php

class Router
{
  private $uri = '';

  public function __construct($url)
  {
    $this->uri = trim($url, '/');
    $this->uri = parse_url($this->uri)['path'];

    switch (true) {
      case preg_match('/^users$/', $this->uri):
        $this->includeHandlerAndView('users', 'users_handler');
        break;

      case preg_match('/^profile$/', $this->uri):
        $this->includeHandlerAndView('profile', 'profile_handler');
        break;

      case preg_match('/^login$/', $this->uri):
        $this->includeHandlerAndView('login', 'login_handler');
        break;

      case preg_match('/^registration$/', $this->uri):
        $this->includeHandlerAndView('registration', 'registration_handler');
        break;

      case preg_match('/^users\/create$/', $this->uri):
        $this->includeHandlerAndView('users_create', 'users_create_handler');
        break;

      case preg_match('/^users\/\d*\/update$/', $this->uri):
        $path = explode('/', $this->uri);
        $_GET['user_id'] = $path[1];
        $this->includeHandlerAndView('users_update', 'users_update_handler');
        break;

      case preg_match("/^users\/\d*\/change_password$/", $this->uri):
        $path = explode('/', $this->uri);
        $_GET['user_id'] = $path[1];
        $this->includeHandlerAndView('users_change_password', 'users_change_password_handler');
        break;

      default :
        http_response_code(404);
        $this->includeHandlerAndView('404');
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