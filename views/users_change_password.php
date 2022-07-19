<form action="/users/<?= $_SESSION['changePassword']['user_id'] ?>/change_password" method='POST'>

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

<a href="/profile" style="font-size:20px">Go back</a>