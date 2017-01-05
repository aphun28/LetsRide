<?php
  /**
   * TEMPORARY SCRIPT - all drives are online automatically
   */

  include 'connectDB.php';

  try {
    $dID = $_SESSION['driver_id'];
      // this.myLocation = {lat: 37.335142, lng: -121.881276};
    $dLat = filter_input(INPUT_POST, 'lat');
    $dLng = filter_input(INPUT_POST, 'lng');

    // insert new ride entry into ride table
    $query = "INSERT INTO network (driver_id, driver_lat, driver_lng) " .
        "VALUES (:d_ID, :d_lat, :d_lng)";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->bindParam(':d_lat', $dLat);
    $result->bindParam(':d_lng', $dLng);
    $result->execute();
  }
  catch(PDOException $ex) {
    echo 'ERROR: '.$ex->getMessage();
  }
?>
