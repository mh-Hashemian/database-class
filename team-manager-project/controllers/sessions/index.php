<?php
$config = require("config.php");

$session_id = $_GET['id'];

$db = new Database($config['database']);
$query = "SELECT * FROM sessions WHERE id = :session_id";

$statement = $db->connection->prepare($query);
$statement->bindParam(':session_id', $session_id);
$statement->execute();

$session = $statement->fetch();

require "views/sessions/index.view.php";


