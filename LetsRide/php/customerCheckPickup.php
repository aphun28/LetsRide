<?php
  /**
   * Checks if driver confirmed pickup or canceled.
   * @return Integer -1 = canceled, 0 = in transit, 1 = picked up
   */

  include 'connectDB.php';

  try {
    $cID = $_SESSION['customer_id'];

    // check if driver canceled
    $query = "SELECT 1 FROM network " .
        "WHERE customer_id = :c_ID;";
    $result = $conn->prepare($query);
    $result->bindParam(':c_ID', $cID);
    $result->execute();
    $count = $result->rowCount();

    if ($count < 1) { // driver canceled
      echo -1;
      return;
    }
    else { // continuing checking for pickup
      $query = "SELECT 1 FROM network " .
          "WHERE customer_id = :c_ID AND accepted >= 2;";
      $result = $conn->prepare($query);
      $result->bindParam(':c_ID', $cID);
      $result->execute();
      $count = $result->rowCount();

      // if pickup confirmed, find ride id
      if ($count == 1) {
        $query = "SELECT * FROM ride " .
           "WHERE customer_id = :c_ID AND end_date IS NULL;";
        $result = $conn->prepare($query);
        $result->bindParam(':c_ID', $cID);
        $result->execute();
        $rideRow = $result->fetch(PDO::FETCH_ASSOC);
        $_SESSION['ride_id'] = $rideRow['ride_id'];
      }
      echo $count;
    }
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }
?>
