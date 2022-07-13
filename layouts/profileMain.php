<?php

$user = findUserById($pdo, $_SESSION['user_id']);

if (!$user) {
  echo "User not found";
  die;
}
?>

<p>Username: <?= $user['username'] ?></p>
<p>Email: <?= $user['email'] ?></p>
<p>ID: <?= $user['user_id'] ?></p>

<form action="/" method="POST" enctype="multipart/form-data">

  <input type="file" name="image">
  <button type="submit">Save new photo</button>

</form>