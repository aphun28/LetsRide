<?php
  /**
   * Global available to all scripts that include this script.
   */

  // Locations
  $backURL = './';
  $riderMainURL = 'rider.php';
  $driverMainURL = 'driver.php';
  $registerSuccessURL = 'register-success.php';

  // Starts session if does not exist.
  function startSession() {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
  }

  // Ends session.
  function endSession() {
    $_SESSION = array();
    session_destroy();
  }
?>