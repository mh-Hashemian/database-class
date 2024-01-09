<?php

class Report extends Database
{
  public function __construct($config, $username = 'root', $password = '')
  {
    parent::__construct($config, $username, $password);
  }
  public function incomePerSession($teamId, $fromDate, $toDate)
  {
    $query = "
      select s.date, SUM(amount_paid) as amount_paid
      from attendance_transactions at
               join sessions s on s.id = at.session_id
      where team_id = :team_id
        AND s.ended_at IS NOT NULL
        AND date BETWEEN DATE(:from_date) and DATE(:to_date)
      group by s.id, s.date
      order by s.date;
    ";

    $statement = $this->connection->prepare($query);
    $statement->bindParam('team_id', $teamId);
    $statement->bindParam('from_date', $fromDate);
    $statement->bindParam('to_date', $toDate);
    $statement->execute();
    $totalIncome = $statement->fetchAll();

    return array_map(function ($p) {
      $p['date'] = formatDate($p['date']);
      return $p;
    }, $totalIncome);
  }

  public function topActivePlayers($teamId, $count) {
    $query = "
      with rankedPlayers as (
        select count(p.id) as presence_count,
          dense_rank() over (order by count(at.player_id) desc) as rnk,
          p.id, p.first_name, p.last_name
        from players p
        join attendance_transactions at on at.player_id = p.id
        join sessions s on s.id = at.session_id
        where p.team_id = :team_id and s.ended_at is not null
        group by p.id
        order by presence_count desc
      )
      select * from rankedPlayers where rnk <= :count;
    ";

    $statement = $this->connection->prepare($query);
    $statement->bindParam('team_id', $teamId);
    $statement->bindParam('count', $count);
    $statement->execute();

    return $statement->fetchAll();
  }

  public function averageIncomePerSession($teamId) {
    $query = "
      select count(*) as sessions_count, round(avg(totalAmount)) as average_amount_per_session
        from (
            select sum(amount_paid) as totalAmount
            from sessions s
            join attendance_transactions at on s.id = at.session_id
            where team_id = :team_id and ended_at is not null
            group by session_id
        ) T
    ";

    $statement = $this->connection->prepare($query);
    $statement->bindParam("team_id", $teamId);
    $statement->execute();

    return $statement->fetch();
  }

  public function financialBalance($teamId) {
    $query = "
      select sum(totalAmountPaid) as total_team_income, sum(totalAmountOwed) as total_players_debts
        from (
            select sum(amount_paid) as totalAmountPaid,
                sum(amount_owed) as totalAmountOwed
            from sessions s
            join attendance_transactions at on s.id = at.session_id
            where team_id = :team_id and ended_at is not null
            group by session_id
        ) T
    ";

    $statement = $this->connection->prepare($query);
    $statement->bindParam("team_id", $teamId);
    $statement->execute();

    return $statement->fetch();
  }
}