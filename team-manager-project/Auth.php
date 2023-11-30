<?php

class Auth {
  private $db_connection;

  public function __construct($db_connection) {
    $this->db_connection = $db_connection;
  }

  public function get_user($email) {
    $query = "SELECT * FROM users WHERE email = :email";
    $statement = $this->db_connection->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if(!$user) {
      return null;
    }

    return $user;
  }

  public function register($first_name, $last_name, $email, $password) {
    $user_exists = $this->get_user($email);

    if ($user_exists) {
      return null;
    }

    $query = "
      INSERT INTO users (`first_name`, `last_name`, `email`, `password`) 
      VALUES (:first_name, :last_name, :email, :password)
    ";
    $statement = $this->db_connection->prepare($query);
    $statement->bindParam(':first_name', $first_name);
    $statement->bindParam(':last_name', $last_name);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', $password);
    $result = $statement->execute();

    $user_id = $this->db_connection->lastInsertId();

    return $user_id;
  }

  public function login($email, $password) {
    $user = $this->get_user($email);

    if (is_null($user) || !password_verify($password, $user['password'])) {
      return [
        'user' => null,
        'error_message' => 'ایمیل یا گذرواژه اشتباه است!',
      ];
    }

    return [
      'user' => [
        'user_id' => $user['id'],
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'email' => $user['email']
      ],
      'error_message' => null,
    ];
  }
}