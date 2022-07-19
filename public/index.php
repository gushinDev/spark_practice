<?php
include '../config/config.php';
include '../functions/functions.php';
include '../classes/allClasses.php';
include '../views/header.php';
include '../views/navigation.php';
new Router($_SERVER['REQUEST_URI']);
include '../views/footer.php';