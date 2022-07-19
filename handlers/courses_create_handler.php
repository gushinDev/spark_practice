<?php

include '../config/config.php';

checkAuth();

if(isset($_POST['create_course'])) {
  $course = new Course($pdo);
  $course->createNewCourse($_SESSION['user_id'], $_POST['course_title']);
  header('Location: /courses');
}