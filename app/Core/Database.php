<?php

namespace app\Core;

use \PDO;

class Database
{
  private string $host = 'localhost';
  private string $username = 'eu';
  private string $password = 'Euro2011!';
  private string $db = 'course';
  private string $dsn;
  private PDO $pdo;

  public function __construct()
  {
    $this->dsn = "mysql:host=$this->host;dbname=$this->db";
    $this->pdo = new PDO($this->dsn, $this->username, $this->password);
    $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }

  public function getConnection(): PDO
  {
    return $this->pdo;
  }
}