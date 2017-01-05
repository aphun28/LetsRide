<?php
  /**
   * Checks if customer canceled request.
   * @return Integer 0 = in transit, 1 = customer canceled
   */

  include 'connectDB.php';

  try {
    $dID = $_SESSION['driver_id'];

    // check if assigned to customer
    $query = "SELECT * FROM network " .
        "WHERE driver_id = :d_ID AND customer_id IS NULL;";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->execute();
    echo $result->rowCount();
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }
?>
