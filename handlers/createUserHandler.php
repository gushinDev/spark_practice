<?php

if (!$_SESSION) {
  header('Location: login.php');
  die;
}
if (!checkAuth() || $_SESSION['role'] != 'admin') {
  header('Location: login.php');
}

if (!checkAuth()) {
  header('Location: login.php');
}

if (checkIsCurrentUserInPost() && checkIsCurrentUserInGet()) {
  header('Location: login.php');
}


if (isset($_SESSION['role']) && $_SESSION['role'] != 'admin') {
  header('Location: users.php');
}

if (!checkAuth()) {
  header('Location: index.php');
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
    };
    echo 'User already exist';
  }
}
