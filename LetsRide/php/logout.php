<?php
  /**
   * Logs user out by ending session and redirecting to homepage.
   */

  include_once '_globals.php';

  startSession();
  endSession();
?>