<?php
  /**
   * Login Driver if correct credentials and saves info to session.
   * @return Integer: -1 = failed, 1 = success
   */
  
  include_once '_globals.php';
  include 'connectDB.php';

  $user = filter_input(INPUT_POST, 'user');
  $pass = filter_input(INPUT_POST, 'pass');

  try {
    // Find user with existing credentials
    $query = "SELECT * FROM driver ".
         "WHERE email = :user AND password = :pass";
    $result = $conn->prepare($query);
    $result->bindParam(':user', $user);
    $result->bindParam(':pass', $pass);
    $result->execute();
    $count = $result->rowCount();

    // FAIL: invalid credentials
    if ($count < 1) {
      echo -1;
    }
    // SUCCESS: save session variables and redirect
    else {
      $row = $result->fetch(PDO::FETCH_ASSOC);
      $_SESSION['driver_id'] = $row['driver_id'];
      $_SESSION['driver_first_name'] = $row['first_name'];
      $_SESSION['driver_last_name'] = $row['last_name'];
      $_SESSION['driver_email'] = $row['email'];
      $_SESSION['driver_phone_number'] = $row['phone_number'];
      $_SESSION['driver_balance'] = $row['balance'];
      $_SESSION['driver_picture'] = $row['picture'];
      $_SESSION['driver_vehicle_id'] = $row['vehicle_id'];
      $_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
      echo 1;
    }
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }
?>