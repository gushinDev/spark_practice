<?php

$user = findUserById($pdo, $_SESSION['user_id']);

if (!$user) {
  echo "User not found";
  die;
}

$userImg = !empty($user['img']) ? $user['img'] : 'default.jpg';

?>

<p>Username: <?= $user['username'] ?></p>
<p>Email: <?= $user['email'] ?></p>
<p>ID: <?= $user['user_id'] ?></p>
<img src="../img/<?= $userImg ?>" alt="img" width="200px">
<br>
<br>
<br>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">

  <input type="file" name="image">
  <br>
  <br>
  <button type="submit" name="changeProfile">Save new photo</button>

</form>