<?php
  /**
   * Accept request from customer.
   * @return Integer -1 = failed, 1 = success
   */

  include 'connectDB.php';

  try {
    $dID = $_SESSION['driver_id'];

    $query = "UPDATE network SET accepted = 1 WHERE driver_id = :d_ID AND customer_id IS NOT NULL;";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->execute();
  }
  catch(PDOException $ex) {
    echo 'ERROR: '.$ex->getMessage();
  }
?>
