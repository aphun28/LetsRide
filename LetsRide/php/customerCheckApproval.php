<?php
  /**
   * Checks if request has been approved or rejected by driver.
   * @return Integer -1 = rejected, 0 = waiting, 1 = approved
   */
  
  include 'connectDB.php';

  try {
    $cID = $_SESSION['customer_id'];

    // check if driver rejected
    $query = "SELECT 1 FROM network " .
        "WHERE customer_id = :c_ID;";
    $result = $conn->prepare($query);
    $result->bindParam(':c_ID', $cID);
    $result->execute();
    $count = $result->rowCount();

    if ($count < 1) { // driver rejected
      echo -1;
      return;
    }
    else { // continuing checking for approval
      $query = "SELECT * FROM network " .
          "WHERE customer_id = :c_ID AND accepted >= 1;";
      $result = $conn->prepare($query);
      $result->bindParam(':c_ID', $cID);
      $result->execute();
      $count = $result->rowCount();

      // accepted, set session variables
      if ($count > 0) {
        $networkRow = $result->fetch(PDO::FETCH_ASSOC);

        // get driver information
        $query = "SELECT * FROM driver " .
          "WHERE driver_id = :d_ID;";
        $result = $conn->prepare($query);
        $result->bindParam(':d_ID', $networkRow['driver_id']);
        $result->execute();
        $driverRow = $result->fetch(PDO::FETCH_ASSOC);

        // get vehicle information
        $query = "SELECT * FROM vehicle " .
          "WHERE vehicle_id = :v_ID;";
        $result = $conn->prepare($query);
        $result->bindParam(':v_ID', $driverRow['vehicle_id']);
        $result->execute();
        $vehicleRow = $result->fetch(PDO::FETCH_ASSOC);

        // get average rating
        $query = "SELECT AVG(driver_stars) AS avg_stars FROM rating " .
            "WHERE rating_id IN (SELECT ride_id FROM ride WHERE driver_id = :d_ID);";
        $result = $conn->prepare($query);
        $result->bindParam(':d_ID', $networkRow['driver_id']);
        $result->execute();
        $ratingRow = $result->fetch(PDO::FETCH_ASSOC);
        $avgRating = $ratingRow['avg_stars'];

        if ($ratingRow['avg_stars'] == NULL) {
          $avgRating = 'No rating';
        }
        else {
          $avgRating = round($avgRating, 2);
        }

        $_SESSION['driver_info'] = array(
          "id" => $networkRow['driver_id'],
          "driverLat" => $networkRow['driver_lat'],
          "driverLng" => $networkRow['driver_lng'],
          "pickupLat" => $networkRow['pickup_lat'],
          "pickupLng" => $networkRow['pickup_lng'],
          "pickupAddr" => $networkRow['pickup_addr'],
          "destLat" => $networkRow['dest_lat'],
          "destLng" => $networkRow['dest_lng'],
          "destAddr" => $networkRow['dest_addr'],
          "name" => $driverRow['first_name'] . ' ' . $driverRow['last_name'],
          "firstName" => $driverRow['first_name'],
          "lastName" => $driverRow['last_name'],
          "phoneNumber" => $driverRow['phone_number'],
          "picture" => $driverRow['picture'],
          "avgRating" => $avgRating,
          "vehiclePlate" => $vehicleRow['license_plate'],
          "vehicleInfo" => $vehicleRow['make'] . ' ' . $vehicleRow['model'],
          "vehicleMake" => $vehicleRow['make'],
          "vehicleModel" => $vehicleRow['model'],
          "vehicleColor" => $vehicleRow['color'],
        );
      }

      echo $count;
    }
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }
?>
