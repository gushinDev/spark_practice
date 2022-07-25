<?php
session_start();
spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    include '../' . $className . '.php';
});
require_once '../app/init.php';
new app\Core\App($_SERVER['REQUEST_URI']);