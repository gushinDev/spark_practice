<?php
include 'includeAll.php';
include '../layouts/header.php';
include '../layouts/navigation.php';
include '../handlers/users_handler.php';
if (!$_SESSION) {
  header('Location: login.php');
  die;
}
include '../layouts/usersMain.php';
include '../layouts/footer.php';
