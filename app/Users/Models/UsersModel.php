<?php

namespace app\Users\Models;

use app\Core\Database;

class UsersModel
{
    private \PDO $connection;

    public function __construct()
    {
        $this->connection = (new Database())->getConnection();
    }

    public function getUsers($pageNumber = 1): array
    {
        $usersPerPage = 15;
        $startedPosition = ($pageNumber - 1) * $usersPerPage;
        $query = 'SELECT * FROM users WHERE deleted = false ORDER BY user_id DESC LIMIT ' . $startedPosition . ', ' . $usersPerPage . ';';
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserById($userId): array|bool
    {
        $query = 'SELECT * FROM users WHERE user_id = :user_id';
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch();
    }

    public function checkUserExist($userData): array|bool
    {
        $query = 'SELECT user_id FROM users WHERE email = :email OR username = :username LIMIT 1';
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['email' => $userData['email'], 'username' => $userData['username']]);
        return $stmt->fetch();
    }

    public function addUser($userData): bool|int
    {
        if ($this->checkUserExist($userData)) {
            return false;
        }
        $query = 'INSERT INTO `course`.`users` (`username`, `email`, `password`, `role`) 
              VALUES (:username, :email, :password, :role)';
        $stmt = $this->connection->prepare($query);
        return $stmt->execute([
          'username' => $userData['username'],
          'email' => $userData['email'],
          'password' => password_hash($userData['password'], PASSWORD_DEFAULT),
          'role' => $userData['role'] ?? 'user'
        ]);
    }

    public function updateUser($userData): bool
    {
        $query = 'UPDATE users SET username = :username, email = :email, role = :role WHERE user_id = :user_id';;
        $stmt = $this->connection->prepare($query);
        return $stmt->execute([
          'username' => $userData['username'],
          'email' => $userData['email'],
          'role' => $userData['role'],
          'user_id' => $userData['user_id']
        ]);
    }

    public function deleteUser($userId): bool
    {
        $query = 'UPDATE users SET deleted = true WHERE user_id = :user_id';
        $stmt = $this->connection->prepare($query);
        return $stmt->execute(['user_id' => $userId]);
    }

    public function getNumberOfUsers()
    {
        $stmt = $this->connection->prepare('SELECT count(*) FROM users WHERE deleted = false');
        $quantityOfUsers = $stmt->execute();
        $quantityOfUsers = $stmt->fetch();
        return $quantityOfUsers['count(*)'];
    }

    public function setNewAvatar() {

    }
}