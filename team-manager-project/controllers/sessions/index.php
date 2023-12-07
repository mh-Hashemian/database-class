<?php
$config = require("config.php");

$session_id = $_GET['id'];

$db = new Database($config['database']);
$sessionsQuery = "SELECT * FROM sessions WHERE id = :session_id";

$statement = $db->connection->prepare($sessionsQuery);
$statement->bindParam(':session_id', $session_id);
$statement->execute();

$session = $statement->fetch();

$players_query = "SELECT *, CONCAT(first_name, ' ', last_name) AS full_name FROM players WHERE team_id = :team_id";
$players = $db->get($players_query, [
  'team_id' => $session['team_id']
]);

$present_players_query = "
  SELECT p.* FROM `sessions_players` sp
  JOIN `players` p ON p.id = sp.player_id
  WHERE session_id = :session_id;
";
$present_players = $db->get($present_players_query, ['session_id' => $session_id]);

$absence_players_query = "
  SELECT * FROM players
  WHERE team_id = :team_id AND id NOT IN (
    SELECT player_id FROM sessions_players
      WHERE session_id = :session_id
  )
";
$absence_players = $db->get($absence_players_query, [':team_id' => $session['team_id'], ':session_id' => $session_id]);
require "views/sessions/index.view.php";


