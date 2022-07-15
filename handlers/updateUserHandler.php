<?php
if (isset($_GET['user_id'])) {
  $userId = $_GET['user_id'];
  $user = findUserById($pdo, $userId);
  if (!$user) {
    echo 'user not found';
    die();
  }

  $_SESSION['updateUserForm'] =
    [
      'user_id'   => $user['user_id'],
      'username'  => $user['username'],
      'email'     => $user['email'],
      'img'       => $user['img']
    ];
}

if (isset($_POST['updateUser'])) {
  $validation = new Validation($_POST);
  $errors = $validation->validateUpdateForm();
  $validation->showValidationErrors();

  $_SESSION['updateUserForm']['username'] = $_POST['username'];
  $_SESSION['updateUserForm']['email'] = $_POST['email'];

  if (!$errors) {
    if (updateUser($pdo)) {
      die(print_r($_SESSION));
      unset($_SESSION['updateUserForm']);
      header('Location: users.php');
    }
    echo 'User with the same username or email already email';
  }
}
