<?php

function preparePagination($pdo, $numRows, $currentPage)
{
  $stmt = $pdo->prepare('SELECT count(*) FROM users WHERE deleted = false');
  $quantityOfUsers = $stmt->execute();
  $quantityOfUsers = $stmt->fetch();
  $num = $quantityOfUsers['count(*)'];

  $pageCount = ceil($num / $numRows);
  $pageStart = 1;
  $pageEnd = $pageCount;

  return [
    'pageStart' => $pageStart,
    'pageEnd' => $pageEnd,
    'currentPage' => $currentPage
  ];
}


function findAllUsers($pdo, int $pageNumber = 1)
{
  $nubmerOfUsersOnOnePage = 15;
  // $stmt = $pdo->prepare('select count(*) from users;');
  $startRowPosition = ($pageNumber - 1) * $nubmerOfUsersOnOnePage;
  $stmt = $pdo->query('SELECT * FROM users WHERE deleted = false ORDER BY user_id DESC LIMIT ' . $startRowPosition . ', ' . $nubmerOfUsersOnOnePage . ';');
  return $stmt;
}

function checkUserAlredyExist($pdo, $userData)
{
  $sql = 'SELECT user_id FROM users WHERE email = :email OR username = :username LIMIT 1';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['email' => $userData['email'], 'username' => $userData['username']]);
  return $stmt->fetch();
}


function createNewUser($pdo, $postData)
{
  $newUserData =
    [
      'username' => $postData['username'],
      'email' => $postData['email'],
      'password' => $postData['password'],
      'role' => $postData['role'] ?? 'user'
    ];

  $pass = $newUserData['password'];
  $newUserData['password'] = password_hash($pass, PASSWORD_BCRYPT);

  $userExist = checkUserAlredyExist($pdo, $newUserData);

  if (!$userExist) {
    $sql = 'INSERT INTO users(username, email, password, role) VALUES(:username, :email, :password, :role)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($newUserData);
    return true;
  }
  return !$userExist;
}

function deleteUser($pdo, $userId)
{
  $sql = 'UPDATE users SET deleted = true WHERE user_id = :user_id';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['user_id' => $userId]);
}

function findUserById($pdo, $userId)
{
  $sql = 'SELECT * FROM users WHERE user_id = :id';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['id' => $userId]);
  return $stmt->fetch();
}

function updateUser($pdo)
{
  $userPostData = [
    'username' => $_POST['username'],
    'email' => $_POST['email'],
    'user_id' => $_POST['user_id'],
    'role' => $_POST['role'] ?? 'user'
  ];

  $sql = 'UPDATE users SET username = :username, email = :email, role = :role WHERE user_id = :user_id';

  $stmt = $pdo->prepare($sql);
  try {
    $stmt->execute($userPostData);
    $stmt->fetch();
    return true;
  } catch (PDOException $e) {
    return true;
  }
}

function checkPasswordMatches($inputPassword, $dbUserPassword)
{
  if ($inputPassword != '' && isset($dbUserPassword)) {
    return  password_verify($inputPassword, $dbUserPassword);
  }
  return false;
}

function updatePasswordById($pdo, $user_id)
{
  $currentUser = findUserById($pdo, $user_id);

  if ($currentUser && checkPasswordMatches($_POST['password'], $currentUser['password'])) {
    $newUserPassword = password_hash($_POST['confirm'], PASSWORD_BCRYPT);
    $sql = 'UPDATE users SET password = :password WHERE user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'password' => $newUserPassword]);
    return true;
  }

  return false;
}



function userLogin($pdo, $username)
{
  $sql = 'SELECT * FROM users WHERE username = :username && deleted = false LIMIT 1 ';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['username' => $username]);
  return $stmt->fetch();
}

function checkAuth()
{
  return isset($_SESSION['user_id']);
}

function checkUserIsAdmin()
{
  return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
}

function checkIsCurrentUserInGet()
{
  return isset($_GET['user_id']) && $_SESSION['user_id'] != $_GET['user_id'];
}

function checkIsCurrentUserInPost()
{
  return isset($_POST['user_id']) && $_SESSION['user_id'] != $_POST['user_id'];
}

function updateSession($pdo, $userId)
{
  $sql = 'SELECT * FROM users WHERE user_id = :user_id';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['user_id' => $userId]);
  $result = $stmt->fetch();
  if ($result) {
    $_SESSION[] = [
      'username' => $result['username'],
      'email' => $result['email'],
      'role' => $result['role']
    ];
  }
}
