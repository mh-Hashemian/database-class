<?php
$config = require base_path('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $json = file_get_contents("php://input");
  $body = json_decode($json, true);
  extract($body);

  $db = new Database($config['database']);
  $query = "
    UPDATE users
    SET 
        first_name = :first_name, 
        last_name = :last_name, 
        email = :email 
    WHERE id = :id;
  ";

  $statement = $db->connection->prepare($query);
  $statement->bindParam(':first_name', $first_name);
  $statement->bindParam(':last_name', $last_name);
  $statement->bindParam(':email', $email);
  $statement->bindParam(':id', $user_id);
  $statement->execute();

  $is_successful = (bool)$statement->rowCount() > 0;

  if ($is_successful) {
    $query = "SELECT id, first_name, last_name, email FROM users WHERE id = :id";
    $statement = $db->connection->prepare($query);
    $statement->bindParam('id', $user_id);
    $statement->execute();

    $updated_user = $statement->fetch();
    echo json_encode($updated_user);
    $_SESSION['user'] = $updated_user;
  } else {
    echo json_encode([
      'status' => 400,
      'error' => 'something went wrong!'
    ]);
  }

}


