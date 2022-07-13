<?php
if (isset($_GET['user_id'])) {
  $userId = $_GET['user_id'];
  $user = findUserById($pdo, $userId);
  if (!$user) {
    echo 'user not found';
    die();
  }
  $_SESSION['updateUserForm']['user_id'] = $user['user_id'];
  $_SESSION['updateUserForm']['username'] = $user['username'];
  $_SESSION['updateUserForm']['email'] = $user['email'];
}


if (isset($_POST['updateUser'])) {
  $validation = new Validation($_POST);
  $errors = $validation->validateUpdateForm();

  foreach ($errors as $error) {
    echo $error;
  }

  if (!$errors) {
    if(updateUser($pdo)) {
      unset($_SESSION['updateUserForm']);
      header('Location: users.php');
    }
    echo 'User with the same username or email already email';
  }
}
