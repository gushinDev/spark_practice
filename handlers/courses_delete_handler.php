<?php
include '../config/config.php';
checkAuth();
if(isset($_GET['course_id'])) {
  $course_id = $_GET['course_id'];
  $course = new Course($pdo);
  $course->deleteCourse($_GET['course_id']);
  header('Location: /courses');
}
