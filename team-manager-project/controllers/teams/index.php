<?php
require base_path('/controllers/auth.middleware.php');
require base_path('/controllers/reports/Report.php');
$config = require base_path('config.php');

$dateTime = new DateTime();
$today = $dateTime->format("Y-m-d");
$oneMonthLater = $dateTime->modify("+1 month")->format("Y-m-d");

$team_id = $_GET['id'];
$fromDate = isset($_GET['from']) ? $_GET['from'] : $today;
$toDate = isset($_GET['to']) ? $_GET['to'] : $oneMonthLater;

$db = new Database($config['database']);

$teamQuery = "SELECT * FROM teams WHERE id = :team_id";
$statement = $db->connection->prepare($teamQuery);
$statement->bindParam('team_id', $team_id);
$statement->execute();

$team = $statement->fetch();

$playersQuery = "SELECT * FROM players WHERE team_id = :team_id AND is_active = TRUE ORDER BY first_name";
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
$topActivePlayers = $report->topActivePlayers($team_id, 3);
$averageIncomePerSession = $report->averageIncomePerSession($team_id);
$financialBalance = $report->financialBalance($team_id);
$incomePerSession = $report->incomePerSession($team_id, $fromDate, $toDate);

addBreadcrumb('صفحه اصلی', '/');
addBreadcrumb($team['name'], '/teams?&id=' . $team_id);

view('team.view.php', [
  'team' => $team,
  'players' => $players,
  'sessions' => $sessions,
  'team_id' => $team_id,
  'formatter' => $formatter,
  'incomePerSession' => json_encode($incomePerSession),
  'fromDate' => $fromDate,
  'toDate' => $toDate,
  'topActivePlayers' => $topActivePlayers,
  'averageIncomePerSession' => $averageIncomePerSession,
  'financialBalance' => $financialBalance
]);