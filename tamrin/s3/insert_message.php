<?php
  $servername = "localhost";
  $username = "root";
  $password = "";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=shop", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully. \n";

    $title = "some problem";
    $body = "some explainations!";
    $user_id = 3;

    $query = "INSERT INTO `messages`(`title`, `body`, `user_id`) 
              VALUES ('$title', '$body', $user_id);
    ";

    $conn->exec($query);
    echo "New record created successfully.";

  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }