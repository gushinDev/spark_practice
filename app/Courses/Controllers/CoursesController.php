<?php

namespace app\Courses\Controllers;

use app\Courses\Models\CoursesModel;

class CoursesController
{
    private CoursesModel $coursesModel;

    public function __construct()
    {
        $this->coursesModel = new CoursesModel();
    }

    public function index()
    {
        $userCourses = $this->coursesModel->findAllUserCourses($_SESSION['user_id']) ?? [];
        require_once '../app/Courses/Views/CoursesView.php';
    }

    public function deleteCourse($courseId)
    {
        $this->coursesModel->deleteCourse($courseId[0]);
        header('Location: /courses');
    }

    public function readCourse($courseId)
    {
        $currentCourse = $this->coursesModel->readCourse($courseId[0]);
        $courseContent = json_decode($currentCourse['content'], JSON_OBJECT_AS_ARRAY);
        require_once '../app/Courses/Views/CurrentCourseView.php';
    }

    public function createCourse()
    {
        if (isset($_POST['create_course'])) {
            $content = [
              [
                'type' => $_POST['type'],
                'content' => $_POST['content']
              ]
            ];
            $contentJSON = json_encode($content);

            $courseData = [
              'title' => $_POST['title'],
              'user_id' => $_SESSION['user_id'],
              'content' => $contentJSON
            ];

            $this->coursesModel->createNewCourse($courseData);
            header('Location: /courses');
        }
        require_once '../app/Courses/Views/CreateCourseFormView.php';
    }

    public function addSection($courseIdParams)
    {
        $courseId = $courseIdParams[0];
        if (isset($_POST['add_section'])) {
            $course = $this->coursesModel->readCourse($courseId);
            $courseContent = json_decode($course['content'], JSON_OBJECT_AS_ARRAY);
            $courseContent[] = [
              'type' => $_POST['type'],
              'content' => $_POST['content']
            ];

            $this->coursesModel->addNewSection($courseId, json_encode($courseContent));
            header('Location: /courses');
        }
        require_once '../app/Courses/Views/AddSectionView.php';
    }


    public function updateCourse($courseIdParams)
    {
        $courseId = $courseIdParams[0];

        if (isset($_POST['update_course'])) {
            $courseData = [
              'title' => $_POST['title'],
              'course_id' => $courseId
            ];
            $this->coursesModel->updateCourse($courseData);
            header('Location: /courses');
        }

        $course = $this->coursesModel->readCourse($courseId);
        $courseContent = json_decode($course['content'], JSON_OBJECT_AS_ARRAY);
        $courseTitle = $course['title'] ?? '';
        require_once '../app/Courses/Views/UpdateCourseView.php';
    }
}