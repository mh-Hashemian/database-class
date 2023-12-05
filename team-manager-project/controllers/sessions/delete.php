<?php
$config = require('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  $json = file_get_contents("php://input");
  $data = json_decode($json, true);

  $session_id = $data['session_id'];

  $db = new Database($config['database']);
  $query = "DELETE FROM sessions WHERE id = :session_id";

  $statement = $db->connection->prepare($query);
  $statement->bindParam(':session_id', $session_id);

  $statement->execute();
}