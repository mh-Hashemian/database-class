<?php
$config = require('config.php');
require 'Attendance.php';

$attendance = new Attendance((new Database($config['database']))->connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $player_ids = $_POST['player_ids'];
  $session_id = $_POST['session_id'];

  $attendance->add($player_ids, $session_id);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  $json = file_get_contents('php://input');
  $data = json_decode($json, true);

  $attendance->remove($data['player_id'], $data['session_id']);
}

