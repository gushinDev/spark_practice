<?php

if (
  (!checkUserIsAdmin() && checkIsCurrentUserInGet()) || (!checkUserIsAdmin() && checkIsCurrentUserInPost())
) {
  header('Location: users');
  die();
}

if (!checkAuth()) {
  header('Location: login');
  die();
}

if (isset($_POST['changePassword'])) {

  $validation = new Validation($_POST);
  $errors = $validation->validateUpdatePasswordForm();
  $validation->showValidationErrors();

  if (!$errors) {
    if (updatePasswordById($pdo, $_POST['user_id'])) {
      unset($_SESSION['changePassword']);
      header('Location: /users');
      die();
    }
    echo 'Wrong current password';
  }
}

if (isset($_GET['user_id'])) {
  $_SESSION['changePassword']['user_id'] = $_GET['user_id'];
}
