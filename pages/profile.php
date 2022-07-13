<?php
include 'includeAll.php';
include '../layouts/header.php';
include '../layouts/navigation.php';
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  die;
}
include '../handlers/profile_handler.php';
include '../layouts/profileMain.php';
include '../layouts/footer.php';
