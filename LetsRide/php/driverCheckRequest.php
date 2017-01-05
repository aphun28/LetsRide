<?php
  /**
   * Checks for request from customers.
   * @return Integer 0 = waiting, 1 = found request
   */

  include 'connectDB.php';

  try {
    $dID = $_SESSION['driver_id'];

    // check if assigned to customer
    $query = "SELECT * FROM network " .
        "WHERE driver_id = :d_ID AND customer_id IS NOT NULL;";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->execute();
    $count = $result->rowCount();

    // requested, set session variables
    if ($count > 0) {
      $networkRow = $result->fetch(PDO::FETCH_ASSOC);

      // get customer information
      $query = "SELECT * FROM customer " .
        "WHERE customer_id = :c_ID;";
      $result = $conn->prepare($query);
      $result->bindParam(':c_ID', $networkRow['customer_id']);
      $result->execute();
      $customerRow = $result->fetch(PDO::FETCH_ASSOC);

        // get average rating
        $query = "SELECT AVG(customer_stars) AS avg_stars FROM rating " .
            "WHERE rating_id IN (SELECT ride_id FROM ride WHERE customer_id = :c_ID);";
        $result = $conn->prepare($query);
        $result->bindParam(':c_ID', $networkRow['customer_id']);
        $result->execute();
        $ratingRow = $result->fetch(PDO::FETCH_ASSOC);
        $avgRating = $ratingRow['avg_stars'];

        if ($ratingRow['avg_stars'] == NULL) {
          $avgRating = 'No rating';
        }
        else {
          $avgRating = round($avgRating, 2);
        }

      // TODO: get average rating
      $_SESSION['customer_info'] = array(
        "id" => $networkRow['customer_id'],
        "pickupLat" => $networkRow['pickup_lat'],
        "pickupLng" => $networkRow['pickup_lng'],
        "pickupAddr" => $networkRow['pickup_addr'],
        "destLat" => $networkRow['dest_lat'],
        "destLng" => $networkRow['dest_lng'],
        "destAddr" => $networkRow['dest_addr'],
        "name" => $customerRow['first_name'] . ' ' . $customerRow['last_name'],
        "firstName" => $customerRow['first_name'],
        "lastName" => $customerRow['last_name'],
        "phoneNumber" => $customerRow['phone_number'],
        "picture" => $customerRow['picture'],
        "avgRating" => $avgRating
      );
    }

    echo $count;
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }
?>
