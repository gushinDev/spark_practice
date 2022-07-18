<?php
$host  = 'localhost';
$user = 'eu';
$password = 'Euro2011!';
$db = 'course';

$dsn = "mysql:host=$host;dbname=$db";
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);