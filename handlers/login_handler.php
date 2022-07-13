<?php

if (isset($_SESSION['user_id'])) {
  header("location: /admin");
}

if (isset($_GET['success'])) {
  unset($_SESSION['registration']);
  echo 'Success registration, now you can login';
}

if (isset($_GET['logout'])) {
  $_SESSION = [];
  header('Location: ' . $_SERVER['PHP_SELF']);
}

if (isset($_POST['submit'])) {

  $_SESSION['loginData']['username'] = $_POST['username'];
  $postPassword = $_POST['password'];

  $validation = new Validation($_POST);
  $errors = $validation->validateLoginForm();

  foreach ($errors as $error) {
    echo $error;
  }

  if (!$errors) {

    $user = userLogin($pdo, $_SESSION['loginData']['username']);

    if ($user && checkPasswordMatches($postPassword, $user['password'])) {
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];
      $_SESSION['user_id'] = $user['user_id'];
      unset($_SESSION['loginData']);
      
      header('Location: profile.php');
    }

    echo 'Wrong username or password';
  }
}
