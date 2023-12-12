<?php

class Transaction extends Database
{
  public function add($transactionData) {
    extract($transactionData);

    $query = "
      UPDATE attendance_transactions
      SET amount_paid = :amount_paid, amount_owed = :amount_owed
      WHERE player_id = :player_id AND session_id = :session_id;
    ";

    $statement = $this->connection->prepare($query);
    $statement->bindParam('amount_paid', $amount_paid);
    $statement->bindParam('amount_owed', $amount_owed);
    $statement->bindParam('player_id', $player_id);
    $statement->bindParam('session_id', $session_id);

    $statement->execute();
  }
}