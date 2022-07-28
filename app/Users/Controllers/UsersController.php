<?php

namespace app\Users\Controllers;

use app\Users\Models\UsersModel;
use app\Users\Validation\UsersValidation;
use app\Users\Validation\ImageValidation;
use app\Access\Controllers\AccessController as AccessController;


class UsersController
{
    private UsersModel $usersModel;
    private string $errorMessages = '';

    public function __construct()
    {
        AccessController::redirectNotLoggedUser();
        $this->usersModel = new UsersModel();
    }

    public function index(): void
    {
        $pagination = $this->getPagination();

        $this->checkValidPageNumber($pagination);

        $userList = $this->usersModel->getUsers($pagination['currentPage']);

        require "../app/Users/Views/UsersView.php";
    }

    private function checkValidPageNumber(array $pagination): void
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

    public function findUser(array $userId): void
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
            header('Location: /users');
            die();
        }
        $user = $this->usersModel->getUserById($userId[0]);
        require "../app/Users/Views/FindUserView.php";
    }

    public function userProfile(): void
    {
        if (isset($_POST['set_new_avatar'])) {
            $validationImage = new ImageValidation($_FILES);
            $errors = $validationImage->validateFile();
            $validationImage->showValidationErrors();

            if (!$errors) {
                $this->deleteOldPhoto();
                $newPhotoPath = $this->usersModel->setNewAvatar($validationImage->getExtension());
                print_r($newPhotoPath);
                if (move_uploaded_file($validationImage->getTempName(), $newPhotoPath)) {
                    header("Location: /profile");
                    die();
                }
            }
        }

        if (isset($_POST['delete_avatar'])) {
            if ($_POST['fileName'] != './img/default.png' && str_contains($_POST['fileName'], $_SESSION['user_id'])) {
                $this->usersModel->deleteAvatar();
                unlink($_POST['fileName']);
            }
        }

        $user = $this->usersModel->getUserById($_SESSION['user_id']);

        $userImg = $user['img'];

        if (empty($user['img']) || !file_exists("./img/{$user['img']}")) {
            $userImg = 'default.png';
        }

        require "../app/Users/Views/UserProfileView.php";
    }

    private function deleteOldPhoto(): void
    {
        $findAll = glob("/img/{$_SESSION['user_id']}*");
        foreach ($findAll as $img) {
            unlink($img);
        }
    }

    public function createUser(): void
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
            header('Location: /users');
            die();
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

    public function updateUser(array $userParams): void
    {
        $userId = $userParams[0];
        $user = $this->usersModel->getUserById($userId);


        if ($_SESSION['role'] !== 'admin') {
            if ((int)$user['user_id'] !== (int)$_SESSION['user_id']) {
                header('Location: /not_found');
                die();
            }
        }

        if (isset($_POST['update_user'])) {
            $_SESSION['updateUserForm'] = [
              'username' => $_POST['username'],
              'email' => $_POST['email'],
              'role' => $_POST['role'] ?? 'user',
              'user_id' => $userId,
            ];

            $validation = new UsersValidation($_SESSION['updateUserForm']);
            $errors = $validation->validateUpdateForm();
            if (!$errors) {
                $this->usersModel->updateUser($_SESSION['updateUserForm']);
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
        $userImg = $user['img'];

        if (empty($user['img']) || !file_exists("./img/{$user['img']}")) {
            $userImg = 'default.png';
        }

        require '../app/Users/Views/UpdateUserView.php';
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

    public function updatePassword($userParams): void
    {
        $userId = array_shift($userParams);
        AccessController::redirectNotOwnerAccount($userId);

        $user = $this->usersModel->getUserById($userId);

        if (isset($_POST['update_password'])) {
            if (password_verify($_POST['current_password'], $user['password'])) {
                $userData = [
                  'user_id' => $user['user_id'],
                  'password' => password_hash($_POST['new_password'], PASSWORD_DEFAULT)
                ];

                if ($this->usersModel->updatePassword($userData)) {
                    header('Location: /users/' . $userId . '/update');
                    die();
                }
            }
            echo 'Wrong current password';
        }

        require_once '../app/Users/Views/UpdatePasswordView.php';
    }

    private function getPagination(): array
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