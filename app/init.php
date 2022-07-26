<?php

session_start();
spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    include '../' . $className . '.php';
});
require_once '../app/Core/Database.php';
require_once '../app/Core/Router.php';
require_once '../app/Core/App.php';