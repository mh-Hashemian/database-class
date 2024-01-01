<?php

  class Database {
    public $connection;

    public function __construct($config, $username = 'root', $password = '') {
      $dsn = 'mysql:' . http_build_query($config, '', ';');

      $this->connection = new PDO($dsn, $username, $password, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ]);

      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function get($query, $params = []) {
      $statement = $this->connection->prepare($query);
      
      // binding parameters
      foreach($params as $paramKey => $paramValue) {
        $statement->bindValue($paramKey, $paramValue);
      }

      $statement->execute();
      return $statement->fetchAll();
    }

    public function getTeamName($team_id)
    {
      $query = "
        SELECT name FROM teams WHERE id = :team_id
      ";
      $statement = $this->connection->prepare($query);
      $statement->bindParam('team_id', $team_id);
      $statement->execute();

      return $statement->fetch()['name'];
    }
  }