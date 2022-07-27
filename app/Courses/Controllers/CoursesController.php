<?php

namespace app\Courses\Controllers;

use app\Access\Controllers\AccessController;
use app\Courses\Models\CoursesModel;

class CoursesController
{
    private CoursesModel $coursesModel;

    public function __construct()
    {
        AccessController::redirectNotLoggedUser();
        $this->coursesModel = new CoursesModel();
    }

    public function index(): void
    {
        $courses = $this->coursesModel->findAllUserCourses($_SESSION['user_id']) ?? [];
        require_once '../app/Courses/Views/UserCoursesView.php';
    }

    public function allCourses(): void
    {
        $courses = $this->coursesModel->findAllCourses();
        require_once '../app/Courses/Views/CatalogCoursesView.php';
    }


    public function deleteCourse($courseId): void
    {
        $this->coursesModel->deleteCourse($courseId[0]);
        header('Location: /courses');
    }

    public function readCourse($courseId): void
    {
        $courseId = $courseId[0];
        $currentCourse = $this->coursesModel->readCourse($courseId);
        $courseContent = json_decode($currentCourse['content'], JSON_OBJECT_AS_ARRAY);

        require_once '../app/Courses/Views/CurrentCourseView.php';
    }

    public function createCourse(): void
    {
        if (isset($_POST['create_course'])) {
            if (empty(trim($_POST['title']))) {
                echo 'Empty title';
            } else {
                $content = [
                  [
                    'section_id' => uniqid(),
                    'type' => $_POST['type'],
                    'content' => strip_tags($_POST['content'])
                  ]
                ];
                $contentJSON = json_encode($content);

                $courseData = [
                  'title' => strip_tags($_POST['title']),
                  'user_id' => $_SESSION['user_id'],
                  'content' => $contentJSON
                ];

                $this->coursesModel->createNewCourse($courseData);
                header('Location: /courses');
            }
        }
        require_once '../app/Courses/Views/CreateCourseFormView.php';
    }

    public function addSection($courseIdParams): void
    {
        $courseId = array_shift($courseIdParams);
        if (isset($_POST['add_section'])) {
            $course = $this->coursesModel->readCourse($courseId);
            $courseContent = json_decode($course['content'], JSON_OBJECT_AS_ARRAY);
            $courseContent[] = [
              'section_id' => uniqid(),
              'type' => $_POST['type'],
              'content' => strip_tags($_POST['content'])
            ];

            $this->coursesModel->addNewSection($courseId, json_encode($courseContent));
            header('Location: /courses');
        }
        require_once '../app/Courses/Views/AddSectionView.php';
    }

    public function updateCourse($courseIdParams): void
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

    public function deleteSection(array $courseData = []): void
    {
        [$courseId, $sectionId] = $courseData;
        $course = $this->coursesModel->readCourse($courseId);
        $content = json_decode($course['content'], JSON_OBJECT_AS_ARRAY);
        $content = array_values(
          array_filter($content, function ($item) use ($sectionId) {
              return $item['section_id'] !== $sectionId;
          })
        );
        $courseData = [
          'course_id' => $courseId,
          'content' => json_encode($content)
        ];
        $this->coursesModel->updateCourseContent($courseData);
        header('Location: /courses/' . $courseId);
    }

    public function updateSection($courseData): void
    {
        [$courseId, $sectionId] = $courseData;
        $course = $this->coursesModel->readCourse($courseId);
        $courseContent = json_decode($course['content'], JSON_OBJECT_AS_ARRAY);
        if (isset($_POST['update_section'])) {
            $newCourseContent = array_map(function ($item) use ($sectionId) {
                if ($item['section_id'] === $sectionId) {
                    return [
                      ...$item,
                      'content' => strip_tags($_POST['content'])
                    ];
                }
            }, $courseContent);

            $updatedCourseData = [
              'course_id' => $courseId,
              'content' => json_encode($newCourseContent)
            ];
            $this->coursesModel->updateCourseContent($updatedCourseData);
            header('Location: /courses/' . $courseId);
        }

        $foundSection = array_values(
          array_filter($courseContent, function ($item) use ($sectionId) {
              return $item['section_id'] === $sectionId;
          })
        );

        [['content' => $content, 'type' => $type]] = $foundSection;
        require_once '../app/Courses/Views/UpdateSectionView.php';
    }
}