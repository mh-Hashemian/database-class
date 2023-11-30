<?php

if (!isset($_SESSION['user'])) {
  header("Location: /login");
  exit();
}

var_dump($_SESSION['user']);

require 'views/index.view.php';