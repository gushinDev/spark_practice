<?php
include '../config/config.php';
if (isset($_SESSION['user_id'])) {
  header("location: /profile");
}

if (isset($_POST['submit'])) {

  $_SESSION['registration']['username'] = $_POST['username'];
  $_SESSION['registration']['email'] = $_POST['email'];
  $_SESSION['registration']['password'] = $_POST['password'];

  $validation = new Validation($_POST);
  $errors = $validation->validateRegistrationForm();
  $validation->showValidationErrors();

  if (!$errors) {
    if (createNewUser($pdo, $_SESSION['registration'])) {
      header('Location: /login?success');
    }
    echo 'User already exist';
  }

}
