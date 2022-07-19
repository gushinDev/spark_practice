<?php

class Course
{
  private $connection;

  public function __construct($pdo) {
    $this->connection = $pdo;
  }

  public function findAllUserCourses($userId){
    $sql = 'SELECT course_id, title, content, author_id, username FROM courses INNER JOIN users on user_id = author_id WHERE user_id = :user_id';
    $stmt = $this->connection->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll();
  }

  public function createNewCourse($userId, $title) {
    $sql = 'INSERT INTO courses (author_id, title) VALUES (:userId, :title)';
    $stmt = $this->connection->prepare($sql);
    $stmt->execute(['userId' => $userId, 'title' => $title]);
  }

  public function deleteCourse($courseId) {
    $sql = 'DELETE FROM courses WHERE course_id = :course_id';
    $stmt = $this->connection->prepare($sql);
    $stmt->execute(['course_id' => $courseId]);
  }
}