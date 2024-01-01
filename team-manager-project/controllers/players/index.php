<?php
require base_path('/controllers/auth.middleware.php');
$config = require base_path('config.php');

$player_id = $_GET['id'];

$db = new Database($config['database']);

$query = "SELECT * FROM players WHERE id = :player_id";
$statement = $db->connection->prepare($query);
$statement->bindParam('player_id', $player_id);
$statement->execute();

$player = $statement->fetch();

$debts_query = "
    SELECT s.id AS session_id, title, date, entrance_fee, amount_owed FROM attendance_transactions at
    JOIN sessions s ON s.id = at.session_id
    WHERE player_id = :player_id AND amount_owed > 0
  ";
$player_debts = $db->get($debts_query, ['player_id' => $player_id]);

$team_name = $db->getTeamName($player['team_id']);

addBreadcrumb('صفحه اصلی', '/');
addBreadcrumb($team_name, '/teams?id=' . $player['team_id']);
addBreadcrumb($player['first_name'] . ' ' . $player['last_name'], '/players?id=' . $player_id);
view("player.view.php", [
  'player' => $player,
  'player_id' => $player_id,
  'player_debts' => $player_debts
]);