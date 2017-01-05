<?php
  /**
   * Complete rating with customer and reset own status
   */

  include 'connectDB.php';

  $stars = $_POST['stars'];
  $comment = $_POST['comments'];

  if (is_null($comment)) {
    $comment = "";
  }

  try {
    //pull driver id, customer id, 
    // $dID = $_SESSION['driver_id'];
    $rID = $_SESSION['ride_id'];

    $query = "UPDATE rating ".
        "SET customer_stars = :stars, customer_comment = :comment " .
        "WHERE rating_id = :r_ID";
    $result = $conn->prepare($query);
    $result->bindParam(':stars', $stars);
    $result->bindParam(':comment', $comment);
    $result->bindParam(':r_ID', $rID);
    $result->execute();

    //pull ride_id matching driver and customer id. Ordered by desc so first row is most recent
    // $query = "SELECT ride_id from RIDE ".
    //          "WHERE driver_id = :d_ID AND customer_id = :c_ID".
    //          "ORDER BY ride_id DESC;";
    // $result = $conn->prepare($query);
    // $result->bindParam(':d_ID', $dID);
    // $result->bindParam(':c_ID', $cID);
    // $result->execute();

    // //pull ride_id
    // $row = $result->fetch(PDO::FETCH_ASSOC);
    // $rID = $row['ride_id'];

    // //check if ratingId that matches rideID currently exists (when customer has already rated driver)
    // $query = "SELECT * from rating ".
    //          "WHERE rating_id = :r_ID;";
    // $result = $conn->prepare($query);
    // $result->bindParam(':r_ID', $rID);
    // $result->execute();
    // $count = $result->rowCount();

    // if ($count < 1) { //first rater, insert into rating table
    //   $query = "INSERT INTO rating(rating_id, driver_stars, driver_comment) " .
    //            "VALUES (:r_ID, :c_Val, :c_Comm)";
    //   $result = $conn->prepare($query);
    //   $result->bindParam(':r_ID', $rID);
    //   $result->bindParam(':d_Val', $driverValue);
    //   $result->bindParam(':d_Comm', $driverComments);
    //   $result->execute();
    // }
    // else { //second rater, update value matching ride_id
    //   $query = "UPDATE rating SET ".
    //            "driver_stars = :d_Val, driver_comment = :d_Comm " .
    //            "WHERE rating_id = :r_ID;";
    //   $result = $conn->prepare($query);
    //   $result->bindParam(':r_ID', $rID);
    //   $result->bindParam(':d_Val', $driverValue);
    //   $result->bindParam(':d_Comm', $driverComments);
    //   $result->execute();
    // }

    include 'driverOffline.php';
    include 'driverOnline.php';
    echo true;
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }

?>
