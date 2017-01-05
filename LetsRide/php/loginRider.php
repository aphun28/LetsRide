<?php
  /**
   * Login Rider if correct credentials and saves info to session.
   * @return Integer: -1 = failed, 1 = success
   */
  
  include_once '_globals.php';
  include 'connectDB.php';

  $user = filter_input(INPUT_POST, 'user');
  $pass = filter_input(INPUT_POST, 'pass');

  try {
    // Find user with existing credentials
    $query = "SELECT * FROM customer ".
         "WHERE email = :email AND password = :pass";
    $result = $conn->prepare($query);
    $result->bindParam(':email', $user);
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
      $_SESSION['customer_id'] = $row['customer_id'];
      $_SESSION['customer_first_name'] = $row['first_name'];
      $_SESSION['customer_last_name'] = $row['last_name'];
      $_SESSION['customer_email'] = $row['email'];
      $_SESSION['customer_phone_number'] = $row['phone_number'];
      $_SESSION['customer_balance'] = $row['balance'];
      $_SESSION['customer_picture'] = $row['picture'];
      $_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
      echo 1;
    }
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }
?>