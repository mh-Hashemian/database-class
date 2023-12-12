<?php
$config = require base_path('config.php');
require 'Transaction.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $player_id = +$_POST['player_id'];
  $session_id = +$_POST['session_id'];
  $amount_paid = +$_POST['amount_paid'];
  $amount_owed = +$_POST['amount_owed'];

  $transaction = new Transaction($config['database']);
  $transaction->add([
    'player_id' => $player_id,
    'session_id' => $session_id,
    'amount_paid' => $amount_paid,
    'amount_owed' => $amount_owed
  ]);
}