<?php
$config = require base_path("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $player_id = $_GET['playerId'];

  $db = new Database($config['database']);
  $query = "
    SELECT s.id AS session_id, title, date, entrance_fee, amount_owed FROM attendance_transactions at
    JOIN sessions s ON s.id = at.session_id
    WHERE player_id = :player_id AND amount_owed > 0
  ";
  $statement = $db->connection->prepare($query);
  $statement->bindParam(':player_id', $player_id);
  $statement->execute();

  $player_debts = $statement->fetchAll();
  $response = json_encode($player_debts);
  echo $response;
}
