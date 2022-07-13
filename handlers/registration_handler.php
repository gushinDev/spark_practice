<?php

if (isset($_SESSION['user_id'])) {
  header("location: index.php"); 
}

if (isset($_POST['submit'])) {

  $_SESSION['registration']['username'] = $_POST['username'];
  $_SESSION['registration']['email'] = $_POST['email'];
  $_SESSION['registration']['password'] = $_POST['password'];

  $validation = new Validation($_POST);
  $errors = $validation->validateRegistrationForm();

  foreach ($errors as $error) {
    echo $error;
  }

  if (!$errors) {
    if (createNewUser($pdo, $_SESSION['registration'])) {
      header('Location: ./login.php?success');
    }

    echo 'User already exist';
  }
}
