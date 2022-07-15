<?php

class Validation
{
  private $formData;
  private $errors = [];

  public function __construct($post_data)
  {
    $this->formData = $post_data;
  }

  public function showValidationErrors()
  {
    $this->errors = array_unique($this->errors);
    foreach ($this->errors as $error) {
      echo $error;
    }
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
    $safeMessage = true;
    $this->validateUsername($safeMessage);
    $this->validatePassword($safeMessage);
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

  private function validateUsername($safeMessage = false)
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

  private function validatePassword($safeMessage = false)
  {
    $password = trim($this->formData['password']);
    $this->passwordValidation($password, $safeMessage);
  }

  private function validateNewPassword()
  {
    $password = trim($this->formData['confirm']);
    $this->passwordValidation($password);
  }

  private function passwordValidation($password, $safeMessage = false)
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

  private function addError($key, $value)
  {
    $this->errors[$key] = $value;
  }
}
