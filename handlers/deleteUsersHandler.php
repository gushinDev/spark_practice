<?php
if (isset($_POST['deleteUser'])) {

  if($_SESSION['role'] != 'admin') {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }

  if($_SESSION['user_id'] != $_POST['user_id']) {
    deleteUser($pdo, $_POST['user_id']);
  }

}
