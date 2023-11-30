<?php
$config = require("config.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $team_name = $_POST['teamName'];

  $db = new Database($config['database']);
  
  $query = "
    INSERT INTO teams (`name`, `user_id`) 
    VALUES (:name, :user_id)
  ";

  $statement = $db->connection->prepare($query);
  $statement->bindParam('name', $team_name);
  $statement->bindParam('user_id', $_SESSION['user']['user_id']);
  $statement->execute();

  $team_id = $db->connection->lastInsertId();

  header("Location: /team?id=" . $team_id);
}