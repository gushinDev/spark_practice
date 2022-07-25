<?php

namespace app\Access\Models;

use app\Core\Database;

class AccessModel
{
  private \PDO $connection;

  public function __construct()
  {
    $this->connection = (new Database())->getConnection();
  }

  public function checkUserByUsername($username): array|bool
  {
    $sql = 'SELECT * FROM users WHERE username = :username && deleted = false LIMIT 1 ';
    $stmt = $this->connection->prepare($sql);
    $stmt->execute(['username' => $username]);
    return $stmt->fetch();
  }

  public function checkPasswordsMatches($inputPassword, $dbUserPassword)
  {
    if ($inputPassword != '' && isset($dbUserPassword)) {
//      die(print_r($inputPassword));
      return password_verify($inputPassword, $dbUserPassword);
    }
    return false;
  }

}