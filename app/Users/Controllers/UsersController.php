<?php

namespace app\Users\Controllers;

use app\Users\Models\UsersModel;
use app\Users\Validation\UsersValidation;

class UsersController
{
    private UsersModel $usersModel;
    private string $errorMessages = '';

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            die();
        }
        $this->usersModel = new UsersModel();
    }

    public function index(): void
    {
        $pagination = $this->getPagination();

        $this->checkValidPageNumber($pagination);

        $userList = $this->usersModel->getUsers($pagination['currentPage']);

        require "../app/Users/Views/UsersView.php";
    }

    private function checkValidPageNumber($pagination): void
    {
        if (!isset($_GET['page'])) {
            header("Location: /users?page={$pagination['pageStart']}");
        }

        if (isset($_GET['page']) && $_GET['page'] < $pagination['pageStart']) {
            header("Location: /users?page={$pagination['pageStart']}");
        }

        if (isset($_GET['page']) && $_GET['page'] > $pagination['pageEnd']) {
            header("Location: /users?page={$pagination['pageEnd']}");
        }
    }

    public function findUser($userId): void
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
            header('Location: /users');
        }
        $user = $this->usersModel->getUserById($userId[0]);
        require "../app/Users/Views/FindUserView.php";
    }

    public function userProfile(): void
    {
        $user = $this->usersModel->getUserById($_SESSION['user_id']);
        $userImg = 'default.png';

        require "../app/Users/Views/UserProfileView.php";
    }

    public function createUser(): void
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
            header('Location: /users');
        }
        if (isset($_POST['create_new_user'])) {
            $_SESSION['createUserForm']['username'] = $_POST['username'];
            $_SESSION['createUserForm']['email'] = $_POST['email'];

            $validation = new UsersValidation($_POST);
            $errors = $validation->validateRegistrationForm();

            if (!$errors) {
                $userData = [
                  'username' => $_POST['username'],
                  'email' => $_POST['email'],
                  'role' => $_POST['role'],
                  'password' => $_POST['password']
                ];

                if ($this->usersModel->addUser($userData)) {
                    unset($_SESSION['createUserForm']);
                    header('Location: /users');
                    die();
                }
                $this->errorMessages = 'User already exist';
            } else {
                $this->errorMessages = implode('', $errors);
            }
        }

        $errorMessages = $this->errorMessages;
        require "../app/Users/Views/CreateUserView.php";
    }

    public function updateUser($userParams): void
    {
        $userId = $userParams[0];
        $user = $this->usersModel->getUserById($userId);

        if ($_SESSION['role'] !== 'admin' && $user['user_id'] !== $_SESSION['user_id']) {
            header('Location: /users');
            die();
        }

        if (!$user) {
            header('Location: /users');
            die();
        }

        if (isset($_POST['update_user'])) {
            $_SESSION['updateUserForm'] = [
              'username' => $_POST['username'],
              'email' => $_POST['email'],
              'role' => $_POST['role'],
              'user_id' => $userId,
            ];

            $validation = new UsersValidation($_SESSION['updateUserForm']);
            $errors = $validation->validateUpdateForm();

            if (!$errors) {
                $this->updateCurrentUser($userId);
                header('Location: /users');
                die();
            }
            $validation->showValidationErrors();
        } else {
            $_SESSION['updateUserForm'] = [
              'user_id' => $user['user_id'],
              'username' => $user['username'],
              'email' => $user['email'],
              'role' => $user['role']
            ];
        }

        require '../app/Users/Views/UpdateUserView.php';
    }

    private function updateCurrentUser($userId): void
    {
        $foundUserInDb = $this->usersModel->checkUserExist($_SESSION['updateUserForm']);

        if ((int)$foundUserInDb['user_id'] !== (int)$userId) {
            $this->usersModel->updateUser($_SESSION['updateUserForm']);
        }
        echo 'User already exist';
    }

    public function deleteUser($userId): void
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
            header('Location: /users');
            die();
        }

        if ((int)$_SESSION['user_id'] !== (int)$userId[0]) {
            $user = $this->usersModel->deleteUser($userId[0]);
            header('Location: /users');
            die();
        }
        header('Location: /users');
        die();
    }

    private function getPagination()
    {
        $usersOnPage = 15;
        $pageStart = 1;
        $currentPage = ctype_digit($_GET['page']) ? $_GET['page'] : $pageStart;
        $numberOfUsers = $this->usersModel->getNumberOfUsers();
        $pageCount = ceil($numberOfUsers / $usersOnPage);
        $pageEnd = $pageCount;

        return [
          'pageStart' => $pageStart,
          'pageEnd' => $pageEnd,
          'currentPage' => $currentPage
        ];
    }

}