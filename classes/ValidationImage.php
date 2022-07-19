<?php

class ValidationImage
{
  private $filename;
  private $tempName;
  private $extension;
  private $errors = [];

  public function __construct($uploadedFile)
  {
    $this->filename = $uploadedFile['image']['name'];
    $this->tempName = $uploadedFile['image']['tmp_name'];
    $this->extension = strToLower(pathinfo($this->filename, PATHINFO_EXTENSION));
  }

  public function getTempName()
  {
    return $this->tempName;
  }

  public function getExtension()
  {
    return $this->extension;
  }

  public function validateFile()
  {
    $this->checkEmptyFile();
    $this->checkWrongFormatFile();
    $this->checkWrongExtensionFile();

    return $this->errors;
  }

  public function showValidationErrors()
  {
    $this->errors = array_unique($this->errors);
    foreach ($this->errors as $error) {
      echo $error;
    }
  }

  private function checkEmptyFile()
  {
    if ($this->tempName == '') {
      $this->errors[] = 'File not found.';
    }
  }

  private function checkWrongFormatFile()
  {
    if ($this->errors) return;

    if (!str_contains(mime_content_type($this->tempName), 'image')) {
      $this->errors[] = 'Unsupported file format. Needs ONLY IMAGE with extensions: jpg, jpeg, png';
    }
  }

  private function checkWrongExtensionFile()
  {
    if ($this->errors) return;

    if ($this->extension != "jpg" && $this->extension != "png" && $this->extension != "jpeg") {
      $errors[] = 'Extension of your file doesn\'t support';
    }
  }
}
