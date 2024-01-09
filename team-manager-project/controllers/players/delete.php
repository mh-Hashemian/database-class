<?php
$config = require base_path("config.php");

$team_id = $_GET['teamId'];
$player_id = $_GET['playerId'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = new Database($config['database']);
  
  $query = "
    UPDATE players SET is_active = FALSE WHERE id = :player_id
  ";

  $statement = $db->connection->prepare($query);
  $statement->bindParam('player_id', $player_id);
  $statement->execute();

  header('Location: /teams?&id=' . $team_id);
}