<?php
  /**
   * Reject request from customer.
   */

  include 'connectDB.php';

  try {
    $dID = $_SESSION['driver_id'];

    // set all customer attributes to null
    $query = "UPDATE network SET customer_id = NULL, " .
        "pickup_lat = NULL, pickup_lng = NULL, " .
        "dest_lat = NULL, dest_lng = NULL, " .
        "pickup_addr = NULL, dest_addr = NULL, " .
        "accepted = 0 " .
        "WHERE driver_id = :d_ID;";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->execute();
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }
?>
