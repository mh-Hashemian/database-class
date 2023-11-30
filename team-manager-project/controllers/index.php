<?php

if (!isset($_SESSION['user'])) {
  header("Location: /login");
  exit();
}

require 'views/index.view.php';