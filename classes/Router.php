<?php
class Router
{
  private $uri = '';

  public function __construct($url) {
    $this->uri = trim($url,'/');
    $this->uri = parse_url($this->uri)['path'];

    switch ($this->uri){
      case 'users':
        $this->includeUsers();
        break;

      default :
        echo 1;
    }
  }

  private function includeUsers() {
    include '../handlers/users_handler.php';
    include '../layouts/usersMain.php';
  }
}