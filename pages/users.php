<?php
include 'includeAll.php';
include '../layouts/header.php';
include '../layouts/navigation.php';

if(!isset($_SESSION['username'])) {
  header('Location: login.php');
  die();
}

include '../handlers/users_handler.php';
include '../layouts/usersMain.php';
include '../layouts/footer.php';
