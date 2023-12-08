<?php

require 'Auth.php';
$config = require base_path('config.php');

if (isset($_SESSION['user'])) {
  header("Location: /");
  exit();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  try {
    $db = new Database($config['database']);
    $auth = new Auth($db->connection);

    $result = $auth->login($email, $password);

    if (isset($result['error_message'])) {
      $errors[] = $result['error_message'];
    }

    $user = $result['user'];
    if (isset($user)) {
      $_SESSION['user'] = [
        'user_id' => $user['user_id'],
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'email' => $user['email']
      ];

      header("Location: /");
    }
  } catch (PDOExeption $e) {
    echo $e;
  }
}



view('login.view.php', [
  'errors' => $errors
]);