<?php
$config = require('config.php');
require 'Auth.php';

if (isset($_SESSION['user'])) {
  header("Location: /");
  exit();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $first_name = $_POST['firstName'];
  $last_name = $_POST['lastName'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password_repeat = $_POST['passwordRepeat'];

  if ($password !== $password_repeat) {
    $errors[] = "گذرواژه با تکرار آن منطبق نیست!";
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "ایمیل وارد شده معتبر نیست!";
  }

  if (empty($errors)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    try {
      $db = new Database($config['database']);

      $auth = new Auth($db->connection);
      $user_exists = $auth->get_user($email, $password);

      if (!$user_exists) {
        $user_id = $auth->register($first_name, $last_name, $email, $hashed);

        if (!$user_id)
          $errors[] = "مشکلی رخ داد!";
        else {
          $_SESSION['user'] = [
            'user_id' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email
          ];

          header("Location: /");
          exit();
        }  
      } else {
        $errors[] = "این حساب کاربری از قبل ساخته شده است!";
      }
    } catch (PDOExeption $e) {
      echo $e;
    }
  }
}

require 'views/register.view.php';
