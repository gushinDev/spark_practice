<?php
include '../config/config.php';

if(!isset($_SESSION['user_id'])) {
  header('Location: /login');
}

if (isset($_POST['setAvatar'])) {

  $validationImage = new ValidationImage($_FILES);
  $errors = $validationImage->validateFile();
  $validationImage->showValidationErrors();

  if (!$errors) {
    deleteOldPhoto();
    $newPhotoPath = setNewPhoto($pdo, $validationImage->getExtension());

    if (move_uploaded_file($validationImage->getTempName(), $newPhotoPath)) {
      header("Location: /profile");
      die();
    }
  }
}

if (isset($_POST['deleteAvatar'])) {
  if ($_POST['fileName'] != '../img/default.png') {
    deleteAvatar($pdo);
  }
}

$user = findUserById($pdo, $_SESSION['user_id']);

if (!$user) {
  echo "User not found";
  die();
}



if (empty($user['img']) || !file_exists("../img/{$user['img']}")) {
  $userImg = 'default.png';
} else {
  $userImg = $user['img'];
}

