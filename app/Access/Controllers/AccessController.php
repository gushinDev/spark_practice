<?php

namespace app\Access\Controllers;

use app\Users\Models\UsersModel;
use app\Access\Models\AccessModel;
use app\Access\Validation\AccessValidation;

class AccessController
{
    private UsersModel $usersModel;
    private AccessModel $accessModel;
    private string $errors;

    public function __construct($actionName)
    {
        $this->redirectLoggedUser($actionName);

        require "../app/Users/Models/UsersModel.php";
        require "../app/Access/Validation/AccessValidation.php";
        $this->usersModel = new UsersModel();
    }

    public function notFound()
    {
        require '../app/Access/Views/NotFoundView.php';
    }

    public function logout(): void
    {
        $_SESSION = [];
        header('Location: /login');
    }

    public function login(): void
    {
        require "../app/Access/Models/AccessModel.php";
        $this->accessModel = new AccessModel();

        if (isset($_POST['user_login'])) {
            $_SESSION['loginData']['username'] = $_POST['username'];

            $validation = new AccessValidation($_POST);
            $errors = $validation->validateLoginForm();

            if (!$errors) {
                $this->loginUser();
            }

            echo 'Wrong username or password';
        }
        require "../app/Access/Views/LoginView.php";
    }

    public function registration(): void
    {
        if (isset($_POST['user_register'])) {
            $this->setRegistrationAutoFillFormData();

            $validation = new AccessValidation($_SESSION['registration']);
            $errors = $validation->validateRegistrationForm();
            $_SESSION['registration']['errors'] = $validation->getErrorsAsString();

            if (!$errors) {
                $this->registerUser();
            }
        }
        require "../app/Access/Views/RegistrationView.php";
    }

    private function loginUser(): void
    {
        $user = $this->accessModel->checkUserByUsername($_SESSION['loginData']['username']);

        if ($user && $this->accessModel->checkPasswordsMatches($_POST['password'], $user['password'])) {
            $_SESSION = [
              'username' => $user['username'],
              'user_id' => $user['user_id'],
              'role' => $user['role']
            ];
            unset($_SESSION['loginData']);
            header('Location: /profile');
        }
    }

    private function registerUser(): void
    {
        if ($this->usersModel->addUser($_SESSION['registration'])) {
            unset($_SESSION['registration']);
            header('Location: /login');
            die();
        }
        $_SESSION['registration']['errors'] = 'user already exist';
    }

    private function setRegistrationAutoFillFormData(): void
    {
        $_SESSION['registration']['username'] = $_POST['username'];
        $_SESSION['registration']['email'] = $_POST['email'];
        $_SESSION['registration']['password'] = $_POST['password'];
    }

    private function redirectLoggedUser($actionName): void
    {
        if ($actionName !== 'logout') {
            if ($this->checkUserUnlogged()) {
                header('Location: /profile');
                die();
            }
        }
    }

    private function checkUserUnlogged(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function redirectUnloggedUser(): void
    {
        if (self::checkUserLogged()) {
            header('Location: /login');
            die();
        }
    }

    public static function checkUserLogged(): bool
    {
        return (!isset($_SESSION['user_id']));
    }
}