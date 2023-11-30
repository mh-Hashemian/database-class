<?php

class Auth {
  private $db_connection;

  public function __construct($db_connection) {
    //$db = new Database($config['database']);
    $this->db_connection = $db_connection;
  }

  public function get_user($email) {
    $query = "SELECT * FROM users WHERE email = :email";
    $statement = $this->db_connection->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if($user) {
      return $user;
    }

    return false;
  }

  public function register($first_name, $last_name, $email, $password) {
    $user_exists = $this->get_user($email);

    if ($user_exists) {
      return false;
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
}