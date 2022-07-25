<?php

namespace app\Users\Validation;

class UsersValidation
{
  private $formData;
  private array $errors = [];

  public function __construct($formData)
  {
    $this->formData = $formData;
  }

  public function showValidationErrors(): void
  {
    $this->errors = array_unique($this->errors);
    foreach ($this->errors as $error) {
      echo $error;
    }
  }

  public function validateRegistrationForm(): array
  {
    $this->validateUsername();
    $this->validateEmail();
    $this->validatePassword();
    return $this->errors;
  }

  public function validateUpdateForm(): array {
      $this->validateUsername();
      $this->validateEmail();
      return $this->errors;
  }

  private function validateUsername(bool $safeMessage = false): void
  {
    $username = trim($this->formData['username']);

    if (empty($username)) {
      $this->addError('username', 'username cannot be empty <br>');
    } else {
      if (!preg_match('/^[a-zA-Z0-9]{6,15}$/', $username)) {
        $errorMessage = $safeMessage ? 'Wrong username or password' : 'username must be 6-12 chars & alphanumeric';
        $this->addError('username', $errorMessage . '<br>');
      }
    }
  }

  private function validateEmail(): void
  {
    $email = trim($this->formData['email']);

    if (empty($email)) {
      $this->addError('email', 'email cannot be empty <br>');
    } else {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->addError('email', 'email must be a valid <br>');
      }
    }
  }


  private function validatePassword(bool $safeMessage = false): void
  {
    $password = trim($this->formData['password']);
    $this->passwordValidation($password, $safeMessage);
  }


  private function passwordValidation(string $password, bool $safeMessage = false): void
  {
    switch (true) {
      case empty($password):
        $this->addError('password', 'password cannot be empty <br>');
        break;

      case (!preg_match('/^.{6,15}$/', $password)):
        $errorMessage = $safeMessage ? 'Wrong username or password' : 'password must be 6-15 chars & alphanumeric';
        $this->addError('password', $errorMessage . '<br>');
        break;
    }
  }

  private function addError(string $key, string $value): void
  {
    $this->errors[$key] = $value;
  }
}