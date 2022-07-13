<?php
if (isset($_POST['changeProfile'])) {

  $filename = $_FILES['image']['name'];
  $tempName = $_FILES['image']['tmp_name'];
  $extension = strToLower(pathinfo($filename, PATHINFO_EXTENSION));

  $errors = [];

  if ($_FILES["image"]["error"]) {
    $errors[] = 'File not found';
  }

  if ($_FILES["image"]["size"] > 5000000) {
    $errors[] = "File is too large.";
  }


  if ($extension != "jpg" && $extension != "png" && $extension != "jpeg") {
    $errors[] = 'Format of your file doesn\'t support';
  }

  if (!$errors) {
    $updatedFileName = $_SESSION['user_id'] . '.' . $extension;
    $path = "../img/" . $updatedFileName;

    $sql = 'UPDATE users SET img = :img WHERE user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['img' => $updatedFileName, 'user_id' => $_SESSION['user_id']]);

    if (file_exists($path)) {
      unlink($path);
    }

    if (move_uploaded_file($tempName, $path)) {
      header("Location: " . $_SERVER['PHP_SELF']);
      die();
    }
  }

  echo 'Image doesn\'t uploaded<br>';
  foreach ($errors as $error) {
    echo $error . '<br>';
  }
  echo '<br>';
}
