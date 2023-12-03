<?php
$config = require('config.php');

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

$sessionsQuery = "SELECT * FROM sessions WHERE team_id = :team_id";
$statement = $db->connection->prepare($sessionsQuery);
$statement->bindParam('team_id', $team_id);
$statement->execute();

$sessions = $statement->fetchAll();

require 'views/team.view.php';