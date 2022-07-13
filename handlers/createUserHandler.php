<?php
if (isset($_SESSION['role']) && $_SESSION['role'] != 'admin') {
  header('Location: users.php');
}

if (!checkAuth()) {
  header('Location: index.php');
}

if (isset($_POST['create'])) {
  $validation = new Validation($_POST);
  $errors = $validation->validateRegistrationForm();
  // Валидатор должен вернуть чистые данные

  foreach ($errors as $error) {
    echo $error;
  }
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
