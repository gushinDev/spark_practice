<?php
include '../config/config.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: /login');
  die();
}

if (isset($_POST['deleteUser'])) {
  if (!checkUserIsAdmin()) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }
  if ($_SESSION['user_id'] != $_POST['user_id']) {
    deleteUser($pdo, $_POST['user_id']);
  }
}

$usersOnPage = 15;
$firstPage = '1';
$currentPage = $_GET['page'] ?? $firstPage;

$pagination = preparePagination($pdo, $usersOnPage, $currentPage);

if (!isset($_GET['page'])) {
  header("Location: ?page={$pagination['pageStart']}");
}

if (isset($_GET['page']) && $_GET['page'] < $pagination['pageStart']) {
  header("Location: ?page={$pagination['pageStart']}");
}

if (isset($_GET['page']) && $_GET['page'] > $pagination['pageEnd']) {
  header("Location: ?page={$pagination['pageEnd']}");
}

$userList = findAllUsers($pdo, $_GET['page']);

