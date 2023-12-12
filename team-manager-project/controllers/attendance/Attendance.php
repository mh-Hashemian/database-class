<?php

class Attendance
{
  private $db_connection;
  public function __construct($db_connection) {
    $this->db_connection = $db_connection;
  }

  public function add($player_ids, $session_id) {
    $query = "INSERT INTO attendance_transactions (player_id, session_id) VALUES";

    foreach ($player_ids as $player_id) {
      $is_last = end($player_ids) === $player_id;
      $char = $is_last ? "" : ",";

      $query = $query . "($player_id, $session_id)" . $char;
    }

    $statement = $this->db_connection->prepare($query);
    $statement->execute();
  }

  public function remove($player_id, $session_id) {
    $query = "DELETE FROM attendance_transactions WHERE player_id = :player_id AND session_id = :session_id";
    $statement = $this->db_connection->prepare($query);
    $statement->bindParam(':player_id', $player_id);
    $statement->bindParam(':session_id', $session_id);

    $statement->execute();
  }
}