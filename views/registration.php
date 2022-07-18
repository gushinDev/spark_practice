<h1 class="header text-center">Registration</h1>
<div class="row" style="max-width: 50%; margin: 0 auto; margin-top: 50px">
  <div class="col-12">
    <form method="POST" action="registration">
      <div class="form-outline mb-4">
        <input type="text" id="form2Example3" class="form-control" name="username" value="<?= $_SESSION['registration']['username'] ?? '' ?>" />
        <label class="form-label" for="form2Example3">User name</label>
      </div>

      <!-- Email input -->
      <div class="form-outline mb-4">
        <input type="email" id="form2Example1" class="form-control" name="email" value="<?= $_SESSION['registration']['email'] ?? '' ?>" />
        <label class="form-label" for="form2Example1">Email address</label>
      </div>

      <!-- Password input -->
      <div class="form-outline mb-4">
        <input type="password" id="form2Example2" class="form-control" name="password" />
        <label class="form-label" for="form2Example2">Password</label>
      </div>

      <div class="form-outline mb-4">
        <input type="password" id="form2Example2" class="form-control" name="confirm" />
        <label class="form-label" for="form2Example2">Confirm password</label>
      </div>

      <!-- Submit button -->
      <div class="div" style="display: flex; align-items: center;">
        <button type="submit" class="btn btn-primary btn-block" style="width: 40%; margin: 0 auto" name="submit">Sign in</button>
      </div>
    </form>
  </div>
</div>