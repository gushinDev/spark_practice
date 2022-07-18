<h1 class="header text-center">Login</h1>
<div class="row" style="max-width: 50%; margin: 0 auto; margin-top: 50px">
  <div class="col-12">
    <form method="POST" action="login">
      <!-- Email input -->
      <div class="form-outline mb-4">
        <input type="text" id="form2Example1" class="form-control" name="username" value="<?= $_SESSION['loginData']['username'] ?? ''; ?>">
        <label class="form-label" for="form2Example1">Username</label>
      </div>

      <!-- Password input -->
      <div class="form-outline mb-4">
        <input type="password" id="form2Example2" class="form-control" name="password" value="" />
        <label class="form-label" for="form2Example2">Password</label>
      </div>

      <!-- Submit button -->
      <div class="div" style="display: flex; align-items: center;">
        <button name='submit' type="submit" class="btn btn-primary btn-block" style="width: 40%; margin: 0 auto">Login</button>
      </div>
    </form>
  </div>
</div>