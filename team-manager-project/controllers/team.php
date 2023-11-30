<?php
$config = require('config.php');

$team_id = $_GET['id'];

$db = new Database($config['database']);

$query = "SELECT * FROM teams WHERE id = :team_id";
$statement = $db->connection->prepare($query);
$statement->bindParam('team_id', $team_id);
$statement->execute();

$team = $statement->fetch();

require 'views/team.view.php';