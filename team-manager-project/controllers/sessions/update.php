<?php
$config = require base_path('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $data = file_get_contents("php://input");

  $session = json_decode($data, true);

  $db = new Database($config['database']);
  $query = "
    UPDATE sessions
    SET 
        title = :title, 
        date = :date, 
        entrance_fee = :entrance_fee, 
        ended_at = FROM_UNIXTIME(:ended_at / 1000)
    WHERE id = :id;
  ";

  $statement = $db->connection->prepare($query);
  $statement->bindParam(':title', $session['title']);
  $statement->bindParam(':date', $session['date']);
  $statement->bindParam(':entrance_fee', $session['entrance_fee']);
  $statement->bindParam(':ended_at', $session['ended_at']);
  $statement->bindParam(':id', $session['session_id']);

  $statement->execute();
}