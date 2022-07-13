<?php
if (isset($_POST['setAvatar'])) {

  $validationImage = new ValidationImage($_FILES);
  $errors = $validationImage->validateFile();

  if (!$errors) {

    $findAll = glob("../img/{$_SESSION['user_id']}*");

    foreach ($findAll as $img) {
      unlink($img);
    }

    $updatedFileName = $_SESSION['user_id'] . '.' . $validationImage->getExtension();
    $path = "../img/" . $updatedFileName;

    $sql = 'UPDATE users SET img = :img WHERE user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['img' => $updatedFileName, 'user_id' => $_SESSION['user_id']]);


    if (move_uploaded_file($validationImage->getTempName(), $path)) {
      header("Location: " . $_SERVER['PHP_SELF']);
      die();
    }
  }

  foreach ($errors as $error) {
    echo $error . '<br>';
  }
  echo '<br>';
}


if (isset($_POST['deleteAvatar'])) {
  if ($_POST['fileName'] != '../img/default.png') {
    $sql = 'UPDATE users SET img = null WHERE user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    unlink($_POST['fileName']);
  }
}
