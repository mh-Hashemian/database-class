<?php
require base_path('controllers/auth.middleware.php');
$config = require base_path('config.php');

$db = new Database($config['database']);

view('profile.view.php', [
  'user' => $_SESSION['user']
]);