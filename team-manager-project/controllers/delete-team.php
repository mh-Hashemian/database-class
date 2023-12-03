<?php
$config = require("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  $team_id = $_GET['teamId'];
  
  $db = new Database($config['database']);
  $query = "DELETE FROM teams WHERE id = :team_id";

  $statement = $db->connection->prepare($query);
  $statement->bindParam(':team_id', $team_id);
  $statement->execute();

}