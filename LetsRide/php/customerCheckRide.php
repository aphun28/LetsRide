<?php
  /**
   * Checks ride status.
   * @return Integer 0 = riding, 1 = finished
   */

  include 'connectDB.php';
  try {
    $dID = $_SESSION['driver_info']['id'];

    // check for end date to confirm ride status
    $query = "SELECT * FROM network " .
        "WHERE driver_id = :d_ID AND accepted >= 3;";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->execute();
    $count = $result->rowCount();

    echo $count;

    // if ($count > 0) {
    //   echo 0;
    // }
    // else {
    //   echo 1;
    // }
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }
?>
