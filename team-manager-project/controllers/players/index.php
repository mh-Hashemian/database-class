<?php
$config = require base_path('config.php');

$player_id = $_GET['id'];

$db = new Database($config['database']);

$query = "SELECT * FROM players WHERE id = :player_id";
$statement = $db->connection->prepare($query);
$statement->bindParam('player_id', $player_id);
$statement->execute();

$player = $statement->fetch();

view("players/index.view.php", [
  'player' => $player,
  'player_id' => $player_id
]);