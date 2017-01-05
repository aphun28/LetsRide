<?php
  /**
   * Validates Driver input fields and check if email already exists.
   */

  include_once '_globals.php';
  include 'connectDB.php';

  // define variables and set to empty values
  $fname = $lname = $email = $pass = $pnumber = $dlicense = $make = $model = $year = $color = $plate ="";
  $fnameErr = $lnameErr = $emailErr = $passErr = $pnumErr = $licenseErr = "";
  $makeErr = $modelErr = $yearErr = $colorErr = $plateErr = "";
  $validData = True;

  //phone number length constant
  $phoneLen = 10;
  $yearLen = 4;

  //series of checks to see if form data is valid
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //checks first name
    if (empty($_POST["first"])) {
      $fnameErr = "First Name is required";
      $validData = False;
    } 
    else {
      $fname = test_input($_POST["first"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
        $fnameErr = "Only letters and white space allowed";
        $validData = False;
      }
    }

    //checks last name
    if (empty($_POST["last"])) {
      $lnameErr = "Last Name is required";
      $validData = False;
    } 
    else {
      $lname = test_input($_POST["last"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
        $lnameErr = "Only letters and white space allowed";
        $validData = False;
      }
    }

    //checks email address
    if (empty($_POST["email"])) {
      $emailErr = "Email is required";
      $validData = False;
    } 
    else {
      $email = test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $validData = False;
      }

      // checks if email exist
      $query = "SELECT * FROM driver " .
          "WHERE email = :input_email;";
      $result = $conn->prepare($query);
      $result->bindParam(':input_email', $email);
      $result->execute();
      if ($result->rowCount() > 0) {
        $emailErr = "Email already exists";
        $validData = False;
      }
    }

    //checks password
    if (empty($_POST["password"])) {
      $passErr = "Password is required";
      $validData = False;
    }
    else {
      $pass = test_input($_POST["password"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$pass)) {
        $passErr = "Only letters and white space allowed";
        $validData = False;
      }
    }

    //checks phone number
    if (empty($_POST["phone"])) {
      $pnumErr = "Phone Number is required";
      $validData = False;
    }
    else {
      $pnumber = test_input($_POST["phone"]);
      if (!preg_match("/^[0-9 ]*$/",$pnumber)) {
        $pnumErr = "Only digits allowed";
        $validData = False;
      }
	  else{
		if(strlen($pnumber) < $phoneLen){
			$pnumErr = "must be exactly 10 characters long.";
			$validData = False;
		}
	  }
    }

    //checks driver's license
    // if (empty($_POST["dlicense"])) {
    // 	$licenseErr = "Driver's License number is required";
    // 	$validData = False;
    // } else {
    // 	$dlicense = test_input($_POST["dlicense"]);
    // 	if (!preg_match("/^[a-zA-Z 0-9 ]*$/",$dlicense)) {
    // 		$licenseErr = "Incorrect format";
    // 		$validData = False;
    // 	}
    // }
    
    //checks make of car
    if (empty($_POST["make"])) {
      $makeErr = "Make of car is required";
      $validData = False;
    } 
    else {
      $make = test_input($_POST["make"]);
      if (!preg_match("/^[0-9 a-zA-Z ]*$/",$make)) {
        $makeErr = "Only digits and letters allowed";
        $validData = False;
      }
    }

    //checks model of car
    if (empty($_POST["model"])) {
      $modelErr = "Model of car is required";
      $validData = False;
    }
    else {
      $model = test_input($_POST["model"]);
      if (!preg_match("/^[0-9 a-zA-Z ]*$/",$model)) {
        $modelErr = "Only digits and letters allowed";
        $validData = False;
      }
    }

    //checks year of car
    if (empty($_POST["year"])) {
      $yearErr = "Year of car is required";
      $validData = False;
    }
    else {
      $year = test_input($_POST["year"]);
      if (!preg_match("/^[0-9 ]*$/",$year)) {
        $yearErr = "Only digits allowed";
        $validData = False;
      }
	  if(strlen($year) < $yearLen){
        $yearErr = "Must be exactly 4 digits long";
        $validData = False;
		}
    }

    //checks color of car
    if (empty($_POST["color"])) {
      $colorErr = "Color of car is required";
      $validData = False;
    }
    else {
      $color = test_input($_POST["color"]);
      if (!preg_match("/^[ a-zA-Z  ]*$/",$color)) {
        $colorErr = "Only letters and white space allowed";
        $validData = False;
      }
    }

    //checks license plate of car
    if (empty($_POST["plate"])) {
      $plateErr = "License plate number is required";
      $validData = False;
    }
    else {
      $plate = test_input($_POST["plate"]);
      if (!preg_match("/^[0-9 a-zA-Z ]*$/",$plate)) {
        $plateErr = "Only digits and letters allowed";
        $validData = False;
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
    
    //if the form data turns out to be valid, set the session variables and then redirect to dri_reg.php
    if($validData == True){
      $_SESSION['first'] = $fname;
      $_SESSION['last'] = $lname;
      $_SESSION['email'] = $email;
      $_SESSION['password'] = $pass;
      $_SESSION['phone'] = $pnumber;
      $_SESSION['license'] = $dlicense;
      $_SESSION['make'] = $make;
      $_SESSION['model'] = $model;
      $_SESSION['year'] = $year;
      $_SESSION['color'] = $color;
      $_SESSION['plate'] = $plate;
      include 'registerCreateDriver.php';
    }
    $validData = True;
  }

  //functions that properly formats data to be tested.
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
