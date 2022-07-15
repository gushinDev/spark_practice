<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: 100vh; margin-right: 50px">
  <a href="/pages/profile.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <svg class="bi me-2" width="40" height="32">
      <use xlink:href="#bootstrap"></use>
    </svg>
    <span class="fs-4">Profile</span>
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
    <li>
      <a href="/pages/users.php" class="nav-link text-white">
        Users
      </a>
    </li>
  </ul>
  <hr>
  <?php if (isset($_SESSION['user_id'])) : ?>
    <div class="col-md-3 text-end">
      <a href="/pages/login.php?logout" class="btn btn-primary me-2">Logout</a>
    </div>
  <?php else : ?>
    <div class="col-md-3 text-end">
      <a href="/pages/login.php" class="btn btn-outline-primary me-2" style="width:200%">Login</a>
      <br>
      <br>
      <a href="/pages/registration.php" class="btn btn-primary me-2" style="width:200%">Sign-up</a>
    </div>
  <?php endif; ?>
</div>

<div style="flex:1;">
  <br><br>