<?php
include '../config/config.php';
if (!$_SESSION) {
  header('Location: login');
  die();
}
if (!checkAuth() || $_SESSION['role'] != 'admin') {
  header('Location: login');
  die();
}

if (checkIsCurrentUserInPost() && checkIsCurrentUserInGet()) {
  header('Location: login');
  die();
}


if (isset($_SESSION['role']) && $_SESSION['role'] != 'admin') {
  header('Location: users');
  die();
}

if (!checkAuth()) {
  header('Location: login');
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
      header('Location: /users');
      die();
    };
    echo 'User already exist';
  }
}
