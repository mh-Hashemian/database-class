<?php
require base_path('/controllers/auth.middleware.php');
$config = require base_path("config.php");

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
  SELECT p.* FROM attendance_transactions at
  JOIN `players` p ON p.id = at.player_id
  WHERE session_id = :session_id AND is_active = TRUE
    AND amount_paid IS NULL
  ORDER BY first_name;
";
$present_players = $db->get($present_players_query, ['session_id' => $session_id]);

$absence_players_query = "
  SELECT * FROM players
  WHERE team_id = :team_id AND is_active = TRUE AND id NOT IN (
    SELECT player_id FROM attendance_transactions
      WHERE session_id = :session_id
  )
  ORDER BY first_name
";
$absence_players = $db->get($absence_players_query, [':team_id' => $session['team_id'], ':session_id' => $session_id]);
$is_session_ended = isset($session['ended_at']);

$debtors_query = "
  SELECT p.id, CONCAT(first_name, ' ', last_name) AS name, amount_owed FROM attendance_transactions at
  JOIN players p ON p.id = at.player_id
  WHERE session_id = :session_id AND amount_owed > 0
";
$debtors = $db->get($debtors_query, ['session_id' => $session_id]);

$collected_amount_query = "
  SELECT SUM(amount_paid) AS collected_amount FROM attendance_transactions
  WHERE session_id = $session_id;
";
$statement = $db->connection->prepare($collected_amount_query);
$statement->execute();
$collected_amount = $statement->fetch()['collected_amount'];

$formatter = new IntlDateFormatter(
  "fa_IR@calendar=persian",
  IntlDateFormatter::FULL,
  IntlDateFormatter::FULL,
  'Asia/Tehran',
  IntlDateFormatter::TRADITIONAL,
  "yyyy/MM/dd");
$formatter->setPattern("dd MMMM yyyy");

$team_name = $db->getTeamName($session['team_id']);

addBreadcrumb('صفحه اصلی', '/');
addBreadcrumb($team_name, '/teams?&id=' . $session['team_id']);
addBreadcrumb($session['title'], '/sessions?id=' . $session_id);
view("session.view.php", [
  'session_id' => $session_id,
  'session' => $session,
  'present_players' => $present_players,
  'absence_players' => $absence_players,
  'is_session_ended' => $is_session_ended,
  'debtors' => $debtors,
  'formatter' => $formatter,
  'collected_amount' => $collected_amount
]);
