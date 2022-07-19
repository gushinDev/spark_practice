<?php
include '../config/config.php';
checkAuth();

$course = new Course($pdo);
$userCourses = $course->findAllUserCourses($_SESSION['user_id']);