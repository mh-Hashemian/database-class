<?php
$config = require('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $player_ids = $_POST['player_ids'];
  $session_id = $_POST['session_id'];

  $db = new Database($config['database']);
  $query = "INSERT INTO sessions_players (player_id, session_id) VALUES";

  foreach ($player_ids as $player_id) {
    $is_last = end($player_ids) === $player_id;
    $char = $is_last ? "" : ",";

    $query = $query . "($player_id, $session_id)" . $char;
  }

  $statement = $db->connection->prepare($query);
  $statement->execute();
}

