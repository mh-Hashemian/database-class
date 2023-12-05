<?php
$config = require('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $data = file_get_contents("php://input");

  $session = json_decode($data, true);

  $db = new Database($config['database']);
  $query = "
    UPDATE sessions
    SET title = :title, date = :date, entrance_fee = :entrance_fee
    WHERE id = :id;
  ";

  $statement = $db->connection->prepare($query);
  $statement->bindParam(':title', $session['title']);
  $statement->bindParam(':date', $session['date']);
  $statement->bindParam(':entrance_fee', $session['entrance_fee']);
  $statement->bindParam(':id', $session['session_id']);

  $statement->execute();
}