<?php
$config = require("config.php");

$team_id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $edited_name = $_POST['teamName'];

  $db = new Database($config['database']);

  $query = "UPDATE teams SET name = :edited_name WHERE id = :team_id";

  $statement = $db->connection->prepare($query);
  $statement->bindParam('edited_name', $edited_name);
  $statement->bindParam('team_id', $team_id);
  $statement->execute();

  header("Location: /team?id=" . $team_id);
}