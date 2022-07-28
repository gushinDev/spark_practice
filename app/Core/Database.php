<?php

namespace app\Core;

use \PDO;

class Database
{
    private string $host;
    private string $username;
    private string $password;
    private string $db;
    private string $dsn;
    private PDO $pdo;

    public function __construct()
    {
        $this->setDatabaseData();
        $this->dsn = "mysql:host=$this->host;dbname=$this->db";
        $this->pdo = new PDO($this->dsn, $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    private function setDatabaseData(): void {
        $dbData = require_once '../app/Config/database.php';
        $this->host = $dbData['host'];
        $this->username = $dbData['username'];
        $this->password = $dbData['password'];
        $this->db = $dbData['db'];
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}