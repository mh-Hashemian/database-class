<?php
$config = require base_path("config.php");

$team_id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $edited_name = $_POST['teamName'];

  $db = new Database($config['database']);

  $query = "UPDATE teams SET name = :edited_name WHERE id = :team_id";

  $statement = $db->connection->prepare($query);
  $statement->bindParam('edited_name', $edited_name);
  $statement->bindParam('team_id', $team_id);
  $statement->execute();

  header("Location: /teams?&id=" . $team_id);
}