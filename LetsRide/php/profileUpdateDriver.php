<?php
  /**
   * Updates Driver's profile and vehicle information.
   */
  
  include_once '_globals.php';
  include 'connectDB.php'; 

  // get driver id
  $driverID = $_SESSION['driver_id'];

  // define variables and set to empty values
  $email = $phone = $pass = $dlicense = $make = $model = $year = $color = $plate = $vID = "" ;
  $fnameErr = $lnameErr = $emailErr = $passErr = $pnumErr = $licenseErr = $makeErr = $modelErr = $yearErr = $colorErr = $plateErr = "";
  $outFirst = $outLast = $outEmail = $outPhone = $outBalance = "";
  $validCarData = true;
    
  //phone number and year length constant
  $phoneLen = 10;
  $yearLen = 4;

  //series of checks to see if form data is valid
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //checks email value and if value is valid, update email
    if (!empty($_POST["email"])) {
      $email = test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
      }
      else {
        // checks if email exist
        $query = "SELECT * FROM driver " .
            "WHERE email = :input_email;";
        $result = $conn->prepare($query);
        $result->bindParam(':input_email', $email);
        $result->execute();
        if ($result->rowCount() > 0) {
          $emailErr = "Email already exists";
        }
        else {
          $sql = "UPDATE driver SET email = '$email' WHERE driver_id = $driverID";
          $result = $conn->query($sql);
          $result->execute();
        }

      }
    }	
    
    //checks phone value and if value is valid, update phone number
    if (!empty($_POST["phone"])) {
      $phone = test_input($_POST["phone"]);
      if (!preg_match("/^[0-9 ]*$/",$phone)) {
        $pnumErr = "Only digits allowed";
      }
      else{
		if(strlen($phone) < $phoneLen){			
			$pnumErr = "Must be exactly 10 characters long.";
		}
		else{
			$sql = "UPDATE driver SET phone_number = $phone WHERE driver_id = $driverID";
			$result = $conn->query($sql);
			$result->execute();
		}
      }
    }
    
    //checks pass value and if value is valid, update password
    if (!empty($_POST["pass"])) {
      $pass = test_input($_POST["pass"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$pass)) {
        $passErr = "Only letters and white space allowed";
      }
      else{
        $sql = "UPDATE driver SET password = '$pass' WHERE driver_id = $driverID";
        $result = $conn->query($sql);
        $result->execute();
      }
    }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["carForm"])) {
    
    //checks make value
    if (empty($_POST["make"])) {
      $makeErr = "Make of car is required";
      $validCarData = false;
    } 
    else {
      $make = test_input($_POST["make"]);
      if (!preg_match("/^[0-9 a-zA-Z ]*$/",$make)) {
        $makeErr = "Only digits and letters allowed";
        $validCarData = false;
      }
    }

    //checks model value
    if (empty($_POST["model"])) {
      $modelErr = "Model of car is required";
      $validCarData = false;
    }
    else {
      $model = test_input($_POST["model"]);
      if (!preg_match("/^[0-9 a-zA-Z ]*$/",$model)) {
        $modelErr = "Only digits and letters allowed";
        $validCarData = false;
      }
    }

    //checks year value
    if (empty($_POST["year"])) {
      $yearErr = "Year of car is required";
      $validCarData = false;
    }
    else {
      $year = test_input($_POST["year"]);
      if (!preg_match("/^[0-9 ]*$/",$year)) {
        $yearErr = "Only digits allowed";
        $validCarData = false;
      }
	  if(strlen($year) < $yearLen){
        $yearErr = "Must be exactly 4 digits long";
        $validData = False;
		}
    }

    //checks color value
    if (empty($_POST["color"])) {
      $colorErr = "Color of car is required";
      $validCarData = false;
    }
    else {
      $color = test_input($_POST["color"]);
      if (!preg_match("/^[ a-zA-Z  ]*$/",$color)) {
        $colorErr = "Only letters and white space allowed";
        $validCarData = false;
      }
    }

    //checks license plate value
    if (empty($_POST["plate"])) {
      $plateErr = "License plate number is required";
      $validCarData = false;
    } 
    else {
      $plate = test_input($_POST["plate"]);

      if (!preg_match("/^[0-9 a-zA-Z ]*$/",$plate)) {
        $plateErr = "Only digits and letters allowed";
        $validCarData = false;
      }

      // checks if license plate exist
      $query = "SELECT * FROM vehicle " .
          "WHERE license_plate = :input_plate;";
      $result = $conn->prepare($query);
      $result->bindParam(':input_plate', $plate);
      $result->execute();
      if ($result->rowCount() > 0) {
        $plateErr = "License plate already exists";
        $validData = False;
      }
    }
    
    //update car data if form data is valid
    if($validCarData == true) {
      $vID = $_SESSION['driver_vehicle_id'];
      $sql = "UPDATE vehicle SET make = '$make', model = '$model', year = $year, color = '$color', license_plate = '$plate' WHERE vehicle_id = $vID";
      $result = $conn->query($sql);
      // $result->execute();
    }

    $validCarData = true;
  }

  //getting driver information from database
  $sql = "SELECT * FROM driver WHERE driver_id = $driverID";
  $result = $conn->query($sql);
  $result->execute();

  $row = $result->fetch(PDO::FETCH_ASSOC);
  $vID = $row["vehicle_id"];
  $outFirst = $row['first_name'];
  $outLast = $row['last_name'];
  $outEmail = $row['email'];
  $outPhone = $row['phone_number'];
  $outBalance = $row['balance'];

  //getting vehicle data from database
  $sql = "SELECT * FROM vehicle WHERE vehicle_id = $vID";
  $result = $conn->query($sql);
  $result->execute();
    
  $row = $result->fetch(PDO::FETCH_ASSOC);
  $make = $row["make"];
  $model = $row["model"];
  $year = $row["year"];
  $color = $row["color"];
  $plate = $row["license_plate"];

  //functions that properly formats data to be tested.
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
