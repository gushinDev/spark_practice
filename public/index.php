<?php
include '../classes/allClasses.php';
include '../functions/functions.php';
include '../layouts/config.php';
include '../layouts/header.php';
include '../layouts/indexNav.php';

$uri = trim($_SERVER['REQUEST_URI'],'/');
$uri = parse_url($uri);

//$router = new Router($_SERVER['REQUEST_URI']);

if ($uri['path'] == 'users') {
  include '../handlers/users_handler.php';
  include '../layouts/usersMain.php';
}

if (preg_match("/^users\/\d*\/update$/", $uri['path'])) {
  $path = explode('/', $uri['path']);
  $_GET['user_id'] = $path[1];
  include '../handlers/updateUserHandler.php';
  include '../layouts/updateUserMain.php';
}

if ($uri['path'] == 'profile') {
  include '../handlers/profile_handler.php';
  include '../layouts/profileMain.php';
}

if ($uri['path'] == 'login') {
  include '../handlers/login_handler.php';
  include '../layouts/login.php';
}

if ($uri['path'] == 'registration') {
  include '../handlers/registration_handler.php';
  include '../layouts/registration.php';
}

if ($uri['path'] == 'users/create') {
  include '../handlers/createUserHandler.php';
  include '../layouts/createUserMain.php';
}

if ($uri['path'] == 'updateUser') {
  include '../handlers/updateUserHandler.php';
  include '../layouts/updateUserMain.php';
}

if (preg_match("/^users\/\d*\/change_password$/", $uri['path'])) {
  $path = explode('/', $uri['path']);
  $_GET['user_id'] = $path[1];
  include '../handlers/changePassword_handler.php';
  include '../layouts/changePasswordForm.php';
}

include '../layouts/footer.php';