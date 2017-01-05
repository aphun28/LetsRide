<?php
  /**
   * Gets driver information once connected.
   * Customer information available success return of customerCheckApproval.php
   * @return Object array of driver info else 0
   */

  include 'connectDB.php';

  try {
    if (isset($_SESSION['driver_info'])) {
      echo json_encode($_SESSION['driver_info']);
    }
    else {
      echo 0;
    }
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }
?>
