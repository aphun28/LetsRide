<?php
  /**
   * Retrieves distance matrix from Google Maps Distance Matrix API.
   * More info: https://developers.google.com/maps/documentation/distance-matrix/intro
   */

  include_once '_config.php';

  header('Content-type: application/json');

  $url = "https://maps.googleapis.com/maps/api/distancematrix/json";
  $key = $API_KEY;
  $pickup = $_POST['pickup'];
  $dest = $_POST['dest'];

  $request = $url .
    "?units=imperial" .
    "&origins=" . urlencode($pickup) .
    "&destinations=" . urlencode($dest) .
    "&departure_time=now" .
    "&key=" . urlencode($key);

  echo file_get_contents($request);
?>
