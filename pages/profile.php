<?php
include 'includeAll.php';
include '../layouts/header.php';
include '../layouts/navigation.php';
if (!$_SESSION) {
  header('Location: login.php');
  die;
}
include '../layouts/profileMain.php';
include '../layouts/footer.php';
