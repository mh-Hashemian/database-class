<?php
require base_path('/controllers/auth.middleware.php');
require base_path('/controllers/reports/Report.php');
$config = require base_path('config.php');

$team_id = $_GET['id'];

$db = new Database($config['database']);

$teamQuery = "SELECT * FROM teams WHERE id = :team_id";
$statement = $db->connection->prepare($teamQuery);
$statement->bindParam('team_id', $team_id);
$statement->execute();

$team = $statement->fetch();

$playersQuery = "SELECT * FROM players WHERE team_id = :team_id";
$statement = $db->connection->prepare($playersQuery);
$statement->bindParam('team_id', $team_id);
$statement->execute();

$players = $statement->fetchAll();

$formatter = new IntlDateFormatter(
  "fa_IR@calendar=persian",
  IntlDateFormatter::FULL,
  IntlDateFormatter::FULL,
  'Asia/Tehran',
  IntlDateFormatter::TRADITIONAL,
  "yyyy/MM/dd");

$sessionsQuery = "SELECT * FROM sessions WHERE team_id = :team_id ORDER BY date";
$statement = $db->connection->prepare($sessionsQuery);
$statement->bindParam('team_id', $team_id);
$statement->execute();

$sessions = $statement->fetchAll();

$report = new Report($config['database']);
$payments_per_date = $report->payments_per_date($team_id);

addBreadcrumb('صفحه اصلی', '/');
addBreadcrumb($team['name'], '/teams?id=' . $team_id);

view('team.view.php', [
  'team' => $team,
  'players' => $players,
  'sessions' => $sessions,
  'team_id' => $team_id,
  'formatter' => $formatter,
  'payments_per_date' => json_encode($payments_per_date)
]);