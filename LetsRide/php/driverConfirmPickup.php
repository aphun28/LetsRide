<?php
  /**
   * Confirm customer pickup.
   * Insert new entry into ride, rating, and payment table.
   */

  include 'connectDB.php';

  try {
    $dID = $_SESSION['driver_id'];
    $cID = $_SESSION['customer_info']['id'];
    $startAddr = $_SESSION['customer_info']['pickupAddr'];
    $endAddr = $_SESSION['customer_info']['destAddr'];

    // update network table for customer
    $query = "UPDATE network SET accepted = 2 WHERE driver_id = :d_ID;";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->execute();

    // insert new ride entry into ride table
    $query = "INSERT INTO ride (driver_id, customer_id, start_addr, end_addr, start_date) " .
        "VALUES (:d_ID, :c_ID, :start_addr, :end_addr, NOW());";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->bindParam(':c_ID', $cID);
    $result->bindParam(':start_addr', $startAddr);
    $result->bindParam(':end_addr', $endAddr);
    $result->execute();

    // retrieve ride id and save to session variable
    $rideID = $conn->lastInsertId();
    $_SESSION['ride_id'] = $rideID;

    // insert new rating with same ride id
    $query = "INSERT INTO rating (rating_id) VALUES (:r_ID);";
    $result = $conn->prepare($query);
    $result->bindParam(':r_ID', $rideID);
    $result->execute();

    // // insert new payment with same ride id
    $query = "INSERT INTO payment (payment_id) VALUES (:p_ID);";
    $result = $conn->prepare($query);
    $result->bindParam(':p_ID', $rideID);
    $result->execute();
  }
  catch(PDOException $ex) {
    echo 'ERROR: '.$ex->getMessage();
  }
?>
