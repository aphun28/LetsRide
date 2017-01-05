<?php
  /**
   * Cancels request for driver.
   */

  include 'connectDB.php';

  try {
    $cID = $_SESSION['customer_id'];

    // set all customer attributes to null
    $query = "UPDATE network SET customer_id = NULL, " .
        "pickup_lat = NULL, pickup_lng = NULL, " .
        "dest_lat = NULL, dest_lng = NULL, " .
        "pickup_addr = NULL, dest_addr = NULL, " .
        "accepted = 0 " .
        "WHERE customer_id = :c_ID;";
    $result = $conn->prepare($query);
    $result->bindParam(':c_ID', $cID);
    $result->execute();
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }
?>
