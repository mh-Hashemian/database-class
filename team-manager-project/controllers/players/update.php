<?php
$config = require base_path('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $player_id = $_POST['playerId'];
  $first_name = $_POST['firstname'];
  $last_name = $_POST['lastname'];
  
  var_dump($player_id, $first_name, $last_name);

  $db = new Database($config['database']);
  $sql = "
    UPDATE players 
    SET first_name = :first_name, last_name = :last_name
    WHERE id = :player_id
  ";
  $statement = $db->connection->prepare($sql);
  $statement->bindParam(':first_name', $first_name);
  $statement->bindParam(':last_name', $last_name);
  $statement->bindParam(':player_id', $player_id);

  $statement->execute();
}