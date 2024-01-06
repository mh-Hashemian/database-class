<?php
require base_path('/controllers/auth.middleware.php');
$config = require base_path('config.php');

addBreadcrumb('صفحه اصلی', '/');
$db = new Database($config['database']);
$query = "
  SELECT t.*, COUNT(CASE WHEN p.is_active = TRUE THEN 1 END) as players_count FROM teams t
  LEFT JOIN players p ON t.id = p.team_id
  WHERE user_id = :user_id
  GROUP BY t.id;
";
$statement = $db->connection->prepare($query);
$statement->bindParam('user_id', $_SESSION['user']['id']);
$statement->execute();

$teams = $statement->fetchAll();

view('index.view.php', [
  'teams' => $teams,
]);