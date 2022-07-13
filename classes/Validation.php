<?php

class Validation
{
  private $formData;
  private $errors = [];

  public function __construct($post_data)
  {
    $this->formData = $post_data;
  }

  public function validateRegistrationForm()
  {
    $this->validateUsername();
    $this->validateEmail();
    $this->validatePassword();
    $this->validatePasswordMatch();
    return $this->errors;
  }

  public function validateLoginForm()
  {
    $this->validateUsername();
    $this->validatePassword();
    return $this->errors;
  }

  public function validateUpdatePasswordForm()
  {
    $this->validatePassword();
    $this->validateNewPassword();
    return $this->errors;
  }

  public function validateUpdateForm()
  {
    $this->validateUsername();
    $this->validateEmail();
    return $this->errors;
  }

  private function validateUsername()
  {
    $username = trim($this->formData['username']);

    if (empty($username)) {
      $this->addError('username', 'username cannot be empty <br>');
    } else {
      if (!preg_match('/^[a-zA-Z0-9]{6,15}$/', $username)) {
        $this->addError('username', 'username must be 6-12 chars & alphanumeric <br>');
      }
    }
  }

  private function validateEmail()
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

  private function validatePasswordMatch()
  {
    $password = trim($this->formData['password']);
    $confirmPassword = trim($this->formData['confirm']);
    if ($password != $confirmPassword) {
      $this->addError('password', 'passwords don\'t matches <br>');
    }
  }

  private function validatePassword()
  {
    $password = trim($this->formData['password']);
    $this->passwordValidation($password);
  }

  private function validateNewPassword()
  {
    $password = trim($this->formData['confirm']);
    $this->passwordValidation($password);
  }

  private function passwordValidation($password)
  {
    switch (true) {
      case empty($password):
        $this->addError('password', 'password cannot be empty <br>');
        break;

      case (!preg_match('/^.{6,15}$/', $password)):
        $this->addError('password', 'password must be 6-15 chars & alphanumeric <br>');
        break;
    }
  }

  private function addError($key, $value)
  {
    $this->errors[$key] = $value;
  }
}
