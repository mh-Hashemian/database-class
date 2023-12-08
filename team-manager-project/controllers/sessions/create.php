<?php
$config = require base_path('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $date = $_POST['date'];
  $entrance_fee = $_POST['fee'];
  $team_id = intval($_GET['teamId']);

  $db = new Database($config['database']);
  $query = "
    INSERT INTO sessions (`title`, `date`, `entrance_fee`, `team_id`)
    VALUES (:title, :date, :entrance_fee, :team_id)
  ";

  $statement = $db->connection->prepare($query);
  $statement->bindParam(':title', $title);
  $statement->bindParam(':date', $date);
  $statement->bindParam(':entrance_fee', $entrance_fee);
  $statement->bindParam(':team_id', $team_id);

  $statement->execute();

  $session_id = $db->connection->lastInsertId();

  redirect("/sessions?id=$session_id");
}