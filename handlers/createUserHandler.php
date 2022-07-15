<?php

if (!$_SESSION) {
  header('Location: login.php');
  die();
}
if (!checkAuth() || $_SESSION['role'] != 'admin') {
  header('Location: login.php');
  die();
}

if (checkIsCurrentUserInPost() && checkIsCurrentUserInGet()) {
  header('Location: login.php');
  die();
}


if (isset($_SESSION['role']) && $_SESSION['role'] != 'admin') {
  header('Location: users.php');
  die();
}

if (!checkAuth()) {
  header('Location: index.php');
  die();
}

if (isset($_POST['create'])) {
  $validation = new Validation($_POST);
  $errors = $validation->validateRegistrationForm();

  $validation->showValidationErrors();

  $_SESSION['createUserForm']['username'] = $_POST['username'];
  $_SESSION['createUserForm']['email'] = $_POST['email'];

  if (!$errors) {
    if (createNewUser($pdo, $_POST)) {
      unset($_SESSION['createUserForm']);
      header('Location: users.php');
      die();
    };
    echo 'User already exist';
  }
}
