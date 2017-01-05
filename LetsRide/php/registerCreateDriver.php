<?php
  /**
   * Register new Driver account.
   */

  include_once '_globals.php';
  include 'connectDB.php'; 

  // define variables and set to empty values
  $vid = $first = $last = $email = $password = $phone = $dlicense = $color = $year = $model = $make =  $plate = ""; 

  $first = $_SESSION["first"];
  $last = $_SESSION["last"];
  $email = $_SESSION["email"];
  $pass = $_SESSION["password"];
  $phone = $_SESSION["phone"];
  $plate = $_SESSION["plate"];
  $make = $_SESSION["make"];
  $model = $_SESSION["model"];
  $year = $_SESSION["year"];
  $color = $_SESSION["color"];

  // create new vehicle
  $query = "INSERT INTO vehicle (license_plate, make, model, year, color) " .
      "VALUES (:v_lp, :v_make, :v_model, :v_year, :v_color);";
  $result = $conn->prepare($query);
  $result->bindParam(':v_lp', $plate);
  $result->bindParam(':v_make', $make);
  $result->bindParam(':v_model', $model);
  $result->bindParam(':v_year', $year);
  $result->bindParam(':v_color', $color);
  $result->execute();

  // get vehicle id of previous query
  $vID = $conn->lastInsertId();

  // create new driver and assign to vehicle
  $query = "INSERT INTO driver (first_name, last_name, email, phone_number, password, vehicle_id) " .
      "VALUES (:fn, :ln, :em, :ph, :pa, :vID);";
  $result = $conn->prepare($query);
  $result->bindParam(':fn', $first);
  $result->bindParam(':ln', $last);
  $result->bindParam(':em', $email);
  $result->bindParam(':ph', $phone);
  $result->bindParam(':pa', $pass);
  $result->bindParam(':vID', $vID);
  $result->execute();

  // end session and redirect to success page
  endSession();
  header('Location: ' . $registerSuccessURL);
?> 