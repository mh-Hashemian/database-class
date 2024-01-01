<?php

class Report extends Database
{
  public function __construct($config, $username = 'root', $password = '')
  {
    parent::__construct($config, $username, $password);
  }

  public function payments_per_date($team_id)
  {
    $query = "
      select s.date, SUM(amount_paid) as amount_paid from attendance_transactions at
      join sessions s on s.id = at.session_id
      where team_id = :team_id 
      AND s.ended_at IS NOT NULL 
      AND MONTH(CURDATE()) = MONTH(date)
      group by s.date;
    ";
    $statement = $this->connection->prepare($query);
    $statement->bindParam('team_id', $team_id);
    $statement->execute();
    $payments = $statement->fetchAll();

    return array_map(function ($p) {
      $p['date'] = formatDate($p['date']);
      return $p;
    }, $payments);
  }
}