<?php
  /**
   * Offline Driver - remove driver from network
   */

  include 'connectDB.php';

  try {
    $dID = $_SESSION['driver_id'];

    // insert new ride entry into ride table
    $query = "DELETE FROM network WHERE driver_id = :d_ID;";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->execute();

  }
  catch(PDOException $ex) {
    echo 'ERROR: '.$ex->getMessage();
  }
?>
