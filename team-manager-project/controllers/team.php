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

require 'views/team.view.php';