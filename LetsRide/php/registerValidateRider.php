<?php
  /**
   * Validates Rider input fields and check if email already exists.
   */

  include_once '_globals.php';
  include 'connectDB.php';

  // define variables and set to empty values
  $fnameErr = $lnameErr = $emailErr = $passErr = $pnumErr = "";
  $fname = $lname = $email = $pass = $pnumber ="";
  $validData = True;

  //phone number length constant
  $phoneLen = 10;

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
      $query = "SELECT * FROM customer " .
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
    
    //if the form data turns out to be valid, set the session variables and then redirect to cust_reg.php
    if($validData == True){
      $_SESSION['first'] = $fname;
      $_SESSION['last'] = $lname;
      $_SESSION['email'] = $email;
      $_SESSION['password'] = $pass;
      $_SESSION['phone'] = $pnumber;
      include 'registerCreateRider.php';
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
