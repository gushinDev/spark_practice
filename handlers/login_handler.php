<?php
include '../config/config.php';

if (isset($_SESSION['user_id'])) {
  header("location: /profile");
}

if (isset($_GET['success'])) {
  unset($_SESSION['registration']);
  echo 'Success registration, now you can login';
}

if (isset($_GET['logout'])) {
  $_SESSION = [];
  header('Location: /login');
}

if (isset($_POST['submit'])) {

  $_SESSION['loginData']['username'] = $_POST['username'];
  $postPassword = $_POST['password'];

  $validation = new Validation($_POST);
  $errors = $validation->validateLoginForm();
  $validation->showValidationErrors();

  if (!$errors) {
    $user = userLogin($pdo, $_SESSION['loginData']['username']);

    if ($user && checkPasswordMatches($postPassword, $user['password'])) {
      setLoginSession($user);
      unset($_SESSION['loginData']);
      header('Location: /profile');
    }
    echo 'Wrong username or password';
  }
}
