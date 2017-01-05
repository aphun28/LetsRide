<?php
  /** 
   * Establish secure connection with database and starts session.
   */
  
  include_once '_globals.php';
  include_once '_config.php';

  startSession();

  // connect to database
  try {
    $settings = 'mysql:host=' . $servername . ';port=' . $port . ';dbname=' . $dbname;
    $conn = new PDO($settings, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
?>