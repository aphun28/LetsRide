<?php
  /**
   * Update driver's location based on current location;
   */

  include 'connectDB.php';

  try {
    $dID = $_SESSION['driver_id'];
    $lat = filter_input(INPUT_POST, 'lat');
    $lng = filter_input(INPUT_POST, 'lng');

    // update network table for customer
    $query = "UPDATE network SET " .
        "driver_lat = :lat, driver_lng = :lng " .
        "WHERE driver_id = :d_ID;";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->bindParam(':lat', $lat);
    $result->bindParam(':lng', $lng);
    $result->execute();

  }
  catch(PDOException $ex) {
    echo 'ERROR: '.$ex->getMessage();
  }
?>
