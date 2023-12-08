<?php
$config = require base_path("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $first_name = $_POST['firstName'];
  $last_name = $_POST['lastName'];
  $team_id = $_GET['teamId'];

  $db = new Database($config['database']);
  
  $query = "
    INSERT INTO players (`first_name`, `last_name`, `team_id`) 
    VALUES (:first_name, :last_name, :team_id)
  ";

  $statement = $db->connection->prepare($query);
  $statement->bindParam('first_name', $first_name);
  $statement->bindParam('last_name', $last_name);
  $statement->bindParam('team_id', $team_id);
  $statement->execute();

  header("Location: /teams?id=" . $team_id);
}