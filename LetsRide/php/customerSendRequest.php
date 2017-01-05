<?php
  /**
   * Finds closest driver and sends request.
   * @return Integer -1 = failed, 1 = success
   */

  include 'connectDB.php';

  try {
    // retrieve location data from post inputs
    $cID = $_SESSION['customer_id'];
    $pickupLat = filter_input(INPUT_POST, 'pickupLat');
    $pickupLng = filter_input(INPUT_POST, 'pickupLng');
    $destLat = filter_input(INPUT_POST, 'destLat');
    $destLng = filter_input(INPUT_POST, 'destLng');
    $pickupAddr = filter_input(INPUT_POST, 'pickupAddr');
    $destAddr = filter_input(INPUT_POST, 'destAddr');
    $rideFare = filter_input(INPUT_POST, 'rideFare');
    $rideDur = filter_input(INPUT_POST, 'rideDur');

    // get list of available drivers
    // $query = "SELECT * FROM network " .
    //          "WHERE customer_id IS NULL;";
    // $result = $conn->prepare($query);
    // $result->execute();
    // $result->setFetchMode(PDO::FETCH_ASSOC);

    // // FAILED: Could not find driver
    // if ($result->rowCount() < 1) {
    //   echo -1;
    //   return;
    // }
    // // SUCCESS: Assign customer to selected driver
    // else {

      // find closest driver
      // TODO: Algorithm to find closest driver based on time away instead of miles
      $closestDriverID = -1;
      $query = "SELECT driver_id, driver_lat, driver_lng, ".
             "(3959 * acos( cos( radians($pickupLat) ) * cos( radians(driver_lat)) * cos( radians(driver_lng) - radians($pickupLng) ) " .
             "+ sin( radians($pickupLat) ) * sin(radians(driver_lat)))) " .
             "AS distance FROM network WHERE customer_id IS NULL HAVING distance < 10 ORDER BY distance LIMIT 1;";
      //$sql = "SELECT driver_lat from network";
      $closeDrivers = $conn->query($query);

      // SUCCESS: 
      if ($closeDrivers->rowCount() > 0) {
        $row = $closeDrivers->fetch(PDO::FETCH_ASSOC);
        $closestDriverID = $row["driver_id"];
           // output data of each row
          //  while($row = $result3->fetch(PDO::FETCH_ASSOC)) {
          //      echo "<br> driver_id: ". $row["driver_id"]. " - Name: ". $row["driver_lat"]. " " . $row["driver_lng"] . " Distance ". $row["distance"] . "<br>";
          //     $closestDriverID = $row['driver_id'];
          //  }

        echo "Requesting driver with id: " . $closestDriverID . "\n";

        // insert information into network table
        $query = "UPDATE network SET customer_id = :c_ID, " .
            "pickup_lat = :pu_lat, pickup_lng = :pu_lng, " .
            "dest_lat = :de_lat, dest_lng = :de_lng, " .
            "pickup_addr = :pu_addr, dest_addr = :de_addr, " .
            "ride_fare = :fare, ride_dur = :dur " .
            "WHERE driver_id = :d_ID;";
        $result = $conn->prepare($query);
        $result->bindParam(':c_ID', $cID);
        $result->bindParam(':pu_lat', $pickupLat);
        $result->bindParam(':pu_lng', $pickupLng);
        $result->bindParam(':de_lat', $destLat);
        $result->bindParam(':de_lng', $destLng);
        $result->bindParam(':pu_addr', $pickupAddr);
        $result->bindParam(':de_addr', $destAddr);
        $result->bindParam(':fare', $rideFare);
        $result->bindParam(':dur', $rideDur);
        $result->bindParam(':d_ID', $closestDriverID);
        $result->execute();
        echo 1;
      } 
      // FAILED: NO CLOSE DRIVER FOUND.
      else {
          //  echo "0 results\n";
          echo -1;
      }
    
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }

?>