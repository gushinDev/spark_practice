<?php
include '../config/config.php';
if (!isset($_SESSION['username'])) {
  header('Location: login');
  die;
}

if (isset($_POST['setAvatar'])) {

  $validationImage = new ValidationImage($_FILES);
  $errors = $validationImage->validateFile();

  if (!$errors) {
    $findAll = glob("./img/{$_SESSION['user_id']}*");

    foreach ($findAll as $img) {
      unlink($img);
    }

    $updatedFileName = $_SESSION['user_id'] . '.' . $validationImage->getExtension();
    $path = "./img/" . $updatedFileName;

    $sql = 'UPDATE users SET img = :img WHERE user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['img' => $updatedFileName, 'user_id' => $_SESSION['user_id']]);

    if (move_uploaded_file($validationImage->getTempName(), $path)) {
      header("Location: /profile");
      die();
    }
  }

  foreach ($errors as $error) {
    echo $error . '<br>';
  }
  echo '<br>';
}


if (isset($_POST['deleteAvatar'])) {
  if ($_POST['fileName'] != './img/default.png') {
    deleteAvatar($pdo);
    unlink($_POST['fileName']);
  }
}

$user = findUserById($pdo, $_SESSION['user_id']);

if (!$user) {
  echo "User not found";
  die();
}

$userImg = $user['img'];

if (empty($user['img']) || !file_exists("./img/{$user['img']}")) {
  $userImg = 'default.png';
}

