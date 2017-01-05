<?php
  /**
   * Gets customer information once connected.
   * Customer information available success return of driverCheckRequest.php
   * @return Object array of customer info else 0
   */

  include 'connectDB.php';

  try {
    if (isset($_SESSION['customer_info'])) {
      echo json_encode($_SESSION['customer_info']);
    }
    else {
      echo 0;
    }
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }
?>
