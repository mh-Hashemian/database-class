<?php
$config = require base_path('config.php');

$player_id = $_GET['id'];

$db = new Database($config['database']);

$query = "SELECT * FROM players WHERE id = :player_id";
$statement = $db->connection->prepare($query);
$statement->bindParam('player_id', $player_id);
$statement->execute();

$player = $statement->fetch();

$debts_query = "
  SELECT title, date, amount_owed FROM attendance_transactions at
  JOIN sessions s ON s.id = at.session_id
  WHERE player_id = $player_id AND amount_owed > 0
";
$player_debts = $db->get($debts_query);
var_dump($player_debts);

view("player.view.php", [
  'player' => $player,
  'player_id' => $player_id
]);