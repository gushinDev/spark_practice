<?php
include '../config/config.php';

if (!checkUserIsAdmin()) {
  header('Location: /login');
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
