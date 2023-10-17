<?php
  $servername = "localhost";
  $username = "root";
  $password = "";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=shop", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully. \n";

    $username = "sajad";
    $email = "sajad@gmail.com";
    $password = "sajad1234";

    $query = "INSERT INTO `users`(`username`, `email`, `password`) 
    VALUES ('$username', '$email', '$password')";

    $conn->exec($query);
    echo "New record created successfully.";

  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }