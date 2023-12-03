<?php
$config = require('config.php');

$player_id = $_GET['id'];

$db = new Database($config['database']);

$query = "SELECT * FROM players WHERE id = :player_id";
$statement = $db->connection->prepare($query);
$statement->bindParam('player_id', $player_id);
$statement->execute();

$player = $statement->fetch();

require "views/player.view.php";