<p>Username: <?= $user['username'] ?></p>
<p>Email: <?= $user['email'] ?></p>
<p>ID: <?= $user['user_id'] ?></p>
<img src="../img/<?= $userImg ?>" alt="img" width="200px">

<br>
<br>
<br>

<div>
  <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
    <input type="file" name="image">
    <br>
    <br>
    <button type="submit" name="setAvatar" style="width:20%">Set new avatar</button>
  </form>
  <br>
  <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="fileName" value="../img/<?= $userImg ?>">
    <button type="submit" name="deleteAvatar" style="width:20%">Delete avatar</button>
  </form>

  <a href="updateUser.php?user_id=<?= $user['user_id'] ?> ">Update user</a>
</div>