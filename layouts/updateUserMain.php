<h1 class="text-center">Update user</h1>

<img src="/img/<?= $_SESSION['updateUserForm']['img'] ?? 'default.png'?>" alt="" width="250px">

<form method="POST" action="/users/<?=$_SESSION['updateUserForm']['user_id']?>/update">
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

  <?php if (checkUserIsAdmin()) : ?>
    <div class="form-group">
      <label for="role">Role</label>
      <select name="role" id="role">
        <option value="user">User</option>
        <option value="admin" <?= $_SESSION['updateUserForm']['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
      </select>
    </div>
    <br>
  <?php endif; ?>

  <a href="/users/<?= $_SESSION['updateUserForm']['user_id'] ?? '' ?>/change_password">Change password</a>

  <br>
  <br>
  <div class="form-group">
    <button type="submit" class="btn btn-primary" name="updateUser">Submit</button>
  </div>
</form>

<br>
<br>

<h2 class="text-center"><a href="<?= $_SERVER['HTTP_REFERER']?>">Go back</a></h2>

</div>