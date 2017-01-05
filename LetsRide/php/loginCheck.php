<?php
  /**
   * Checks if user is logged in on home page. If so, redirect to main page.
   */

  include_once '_globals.php';

  startSession();
  
  if (isset($_SESSION['agent']) AND ($_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT']))) {
    // Driver
    if (isset($_SESSION['driver_id'])) {
      header('Location: ' . $driverMainURL);
    }
    // Rider
    else if (isset($_SESSION['customer_id'])) {
      header('Location: ' . $riderMainURL);
    }
  }
?>