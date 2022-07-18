<?php
include '../config/config.php';
include '../functions/functions.php';
include '../classes/allClasses.php';
include '../views/header.php';
include '../views/navigation.php';

$uri = trim($_SERVER['REQUEST_URI'],'/');
$uri = parse_url($uri);

//$router = new Router($_SERVER['REQUEST_URI']);

if ($uri['path'] == 'users') {
  include '../handlers/users_handler.php';
  include '../views/users.php';
}

if (preg_match("/^users\/\d*\/update$/", $uri['path'])) {
  $path = explode('/', $uri['path']);
  $_GET['user_id'] = $path[1];
  include '../handlers/users_update_handler.php';
  include '../views/users_update.php';
}

if ($uri['path'] == 'profile') {
  include '../handlers/profile_handler.php';
  include '../views/profile.php';
}

if ($uri['path'] == 'login') {
  include '../handlers/login_handler.php';
  include '../views/login.php';
}

if ($uri['path'] == 'registration') {
  include '../handlers/registration_handler.php';
  include '../views/registration.php';
}

if ($uri['path'] == 'users/create') {
  include '../handlers/users_create_handler.php';
  include '../views/users_create.php';
}

if ($uri['path'] == 'updateUser') {
  include '../handlers/users_update_handler.php';
  include '../views/users_update.php';
}

if (preg_match("/^users\/\d*\/change_password$/", $uri['path'])) {
  $path = explode('/', $uri['path']);
  $_GET['user_id'] = $path[1];
  include '../handlers/users_change_password_handler.php';
  include '../views/users_change_password.php';
}

include '../views/footer.php';