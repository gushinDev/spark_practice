<?php

namespace app\Access\Validation;

class AccessValidation
{
  private $formData;
  private $errors = [];

  public function __construct($postData)
  {
    $this->formData = $postData;
  }

  public function validateRegistrationForm(): array
  {
    $this->validateUsername();
    $this->validateEmail();
    $this->validatePassword();
    return $this->errors;
  }

  public function validateLoginForm(): array
  {
    $safeMessage = true;
    $this->validateUsername($safeMessage);
    $this->validatePassword($safeMessage);
    return $this->errors;
  }


  private function validateUsername($safeMessage = false): void
  {
    $username = trim($this->formData['username']);

    if (empty($username)) {
      $this->addError('username', 'username cannot be empty');
    } else {
      if (!preg_match('/^[a-zA-Z0-9]{6,15}$/', $username)) {
        $errorMessage = $safeMessage ? 'Wrong username or password' : 'username must be 6-12 chars & alphanumeric';
        $this->addError('username', $errorMessage);
      }
    }
  }

  private function validateEmail(): void
  {
    $email = trim($this->formData['email']);

    if (empty($email)) {
      $this->addError('email', 'email cannot be empty');
    } else {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->addError('email', 'email must be a valid');
      }
    }
  }

  private function validatePassword($safeMessage = false): void
  {
    $password = trim($this->formData['password']);
    switch (true) {
      case empty($password):
        $this->addError('password', 'password cannot be empty');
        break;

      case (!preg_match('/^.{6,15}$/', $password)):
        $errorMessage = $safeMessage ? 'Wrong username or password' : 'password must be 6-15 chars & alphanumeric';
        $this->addError('password', $errorMessage);
        break;
    }
  }

  private function addError($key, $value): void
  {
    $this->errors[$key] = $value;
  }

  public function getErrorsAsString(): string
  {
    return implode('<br>', $this->errors);
  }
}