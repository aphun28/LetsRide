<?php
  /**
   * Complete ride with customer and reset own status
   */

  include 'connectDB.php';

  try {
    $dID = $_SESSION['driver_id'];

    // update ride table to mark completed ride
    $query = "UPDATE ride SET end_date = NOW() " .
              "WHERE driver_id = :d_ID;";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->execute();

    // update network table status
    $query = "UPDATE network SET accepted = 3 " .
              "WHERE driver_id = :d_ID;";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->execute();

    /* reset own status - set all customer attributes to NULL
    $query = "UPDATE network SET customer_id = NULL, " .
        "pickup_lat = NULL, pickup_lng = NULL, " .
        "dest_lat = NULL, dest_lng = NULL, " .
        "pickup_addr = NULL, dest_addr = NULL, " .
        "accepted = 0 " .
        "WHERE driver_id = :d_ID;";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->execute();
    */
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }

?>
