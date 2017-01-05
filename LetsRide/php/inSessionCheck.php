<?php
  /**
   * Checks if user is in session for main pages else back to homepage.
   */

  include_once '_globals.php';

  startSession();

  $currentPage = basename($_SERVER['PHP_SELF']);
  
  if (!(isset($_SESSION['agent']) AND ($_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])))) {
    header('Location: '. $backURL);
  }
  else if ($currentPage == 'rider.php' AND !isset($_SESSION['customer_id'])) {
    header('Location: '. $backURL);
  }
  else if ($currentPage == 'driver.php' AND !isset($_SESSION['driver_id'])) {
    header('Location: '. $backURL);
  }
  else if ($currentPage == 'profile-rider.php' AND !isset($_SESSION['customer_id'])) {
    header('Location: '. $backURL);
  }
  else if ($currentPage == 'profile-driver.php' AND !isset($_SESSION['driver_id'])) {
    header('Location: '. $backURL);
  }
  
?>