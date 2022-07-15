<form action="<?= $_SERVER['PHP_SELF'] ?>" method='POST'>

  <input type="hidden" name="user_id" value="<?= $_SESSION['changePassword']['user_id'] ?? '' ?>" />

  <div class="form-outline mb-4">
    <label for="password">Current password</label>
    <input type="password" name="password" id="password">
  </div>

  <div class="form-outline mb-4">
    <label for="confirm">New password</label>
    <input type="password" name="confirm" id="confirm">
  </div>

  <button type="submit" name="changePassword">Change</button>
</form>

<a href="updateUser.php?update&user_id=<?= $_GET['user_id'] ?? 'users.php' ?>" style="font-size:20px">Go back</a>