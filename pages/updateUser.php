<?php
include 'includeAll.php';
include '../layouts/header.php';
include '../layouts/navigation.php';


if (!$_SESSION) {
  header('Location: login.php');
  die;
}
if (!checkAuth() || $_SESSION['role'] != 'admin') {
  header('Location: login.php');
}
include '../handlers/updateUserHandler.php';
?>


<h1 class="text-center">Update user</h1>
<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
  <input type="hidden" name="user_id" value="<?= $_SESSION['updateUserForm']['user_id'] ?? '' ?>" />

  <div class="form-group">
    <label for="username">User name</label>
    <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Enter your name" name="username" value="<?= $_SESSION['updateUserForm']['username'] ?? '' ?>">
  </div>
  <br>

  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="<?= $_SESSION['updateUserForm']['email'] ?? '' ?>">
  </div>
  <br>

  <div class="form-group">
    <label for="role">Role</label>
    <select name="role" id="role">
      <option value="admin">Admin</option>
      <option value="user" selected>User</option>
    </select>
  </div>
  <br>

  <div class="form-group">
    <button type="submit" class="btn btn-primary" name="updateUser">Submit</button>
  </div>
</form>

<br>
<br>

<div class="form-group">
  <form action="./changePassword.php" method="post">
    <input type="hidden" name="user_id" value="<$user['user_id'] ?>" />
    <button type="submit" name="updatePassword">Change password</button>
  </form>
</div>
<br>
<h2 class="text-center"><a href="users.php">Go back</a></h2>

</div>

<?php require '../layouts/footer.php'; ?>