<?php
$config = require('config.php');

if (!isset($_SESSION['user'])) {
  header("Location: /login");
  exit();
}

$db = new Database($config['database']);
$query = "
  SELECT t.*, COUNT(p.id) as players_count FROM teams t
  LEFT JOIN players p ON t.id = p.team_id
  WHERE user_id = :user_id
  GROUP BY t.id;
";
$statement = $db->connection->prepare($query);
$statement->bindParam('user_id', $_SESSION['user']['user_id']);
$statement->execute();

$teams = $statement->fetchAll();

require 'views/index.view.php';