<?php

namespace app\Courses\Models;

use app\Core\Database;

class CoursesModel
{
    private \PDO $connection;

    public function __construct()
    {
        $this->connection = (new Database())->getConnection();
    }

    public function findAllUserCourses($userId): bool|array
    {
        $sql = 'SELECT course_id, title, content, author_id, username FROM courses INNER JOIN users on user_id = author_id WHERE user_id = :user_id';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function deleteCourse($courseId): void
    {
        $sql = 'DELETE FROM courses WHERE course_id = :course_id';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['course_id' => $courseId]);
    }

    public function createNewCourse($courseData): void
    {
        $sql = 'INSERT INTO courses (author_id, title, content) VALUES (:userId, :title, :content)';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
          'userId' => $courseData['user_id'],
          'title' => $courseData['title'],
          'content' => $courseData['content']
        ]);
    }


    public function readCourse($courseId)
    {
        $sql = 'SELECT * FROM courses WHERE course_id = :course_id';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['course_id' => $courseId]);
        return $stmt->fetch();
    }


    public function addNewSection($courseId, $content): bool
    {
        $sql = 'UPDATE courses SET content = :content WHERE course_id = :course_id';
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
          'course_id' => $courseId,
          'content' => $content
        ]);
    }

    public function updateCourse($courseData)
    {
        $sql = 'UPDATE courses SET title = :title WHERE course_id = :course_id';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
          'title' => $courseData['title'],
          'course_id' => $courseData['course_id']
        ]);
    }


}