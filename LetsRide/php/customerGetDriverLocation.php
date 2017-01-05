<?php
  /**
   * Gets driver's location as lat and lng.
   * @return Object holding lat and lng
   */

  include 'connectDB.php';
  try {
    $dID = $_SESSION['driver_info']['id'];

    // check for end date to confirm ride status
    $query = "SELECT * FROM network " .
        "WHERE driver_id = :d_ID;";
    $result = $conn->prepare($query);
    $result->bindParam(':d_ID', $dID);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $location = json_encode(array(
      "lat" => $row['driver_lat'], 
      "lng" => $row['driver_lng'],
    ));
    echo $location;
  }
  catch(PDOException $ex) {
      echo 'ERROR: '.$ex->getMessage();
  }
?>
