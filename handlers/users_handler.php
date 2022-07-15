<?php

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  die();
}

$usersOnPage = 15;
$currentPage = $_GET['page'] ?? '1';
$pagination = preparePagination($pdo, $usersOnPage, $currentPage);


if (isset($_POST['deleteUser'])) {

  // if(!$_SESSION['user_id'] == $_POST['user_id']) {
  deleteUser($pdo, $_POST['user_id']);
  // }


  if ($_SESSION['user_id'] == $_POST['user_id']) {
    $_SESSION = [];
    header('Location: users.php');
  } else {
    header('Location: users.php');
  }
}

if (!isset($_GET['page'])) {
  header("Location: ?page={$pagination['pageStart']}");
}

if (isset($_GET['page']) && $_GET['page'] < $pagination['pageStart']) {
  header("Location: ?page={$pagination['pageStart']}");
}

if (isset($_GET['page']) && $_GET['page'] > $pagination['pageEnd']) {
  header("Location: ?page={$pagination['pageEnd']}");
}

if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
  <form action="createUser.php" method="POST">
    <button type="submit" style="font-size:25px">Create new</button>
  </form>
<?php endif; ?>