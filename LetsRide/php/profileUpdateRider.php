<?php
  /**
   * Updates Riders's profile.
   */
  
  include_once '_globals.php';
  include 'connectDB.php'; 
  
  // get rider id
  $riderID = $_SESSION['customer_id'];

  // define variables and set to empty values
  $email = $phone = $pass = "";
  $emailErr = $pnumErr = $passErr = "";
  $outFirst = $outLast = $outEmail = $outPhone = $outBalance = "";

  //phone number length constant
  $phoneLen = 10;

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
        $query = "SELECT * FROM customer " .
            "WHERE email = :input_email;";
        $result = $conn->prepare($query);
        $result->bindParam(':input_email', $email);
        $result->execute();
        if ($result->rowCount() > 0) {
          $emailErr = "Email already exists";
        }
        else {
          // update email
          $sql = "UPDATE customer SET email = '$email' WHERE customer_id = $riderID";
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
      else {
		if(strlen($phone) < $phoneLen){			
			$pnumErr = "Must be exactly 10 characters long.";
		}
		else{
			$sql = "UPDATE customer SET phone_number = $phone WHERE customer_id = $riderID";
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
        $sql = "UPDATE customer SET password = '$pass' WHERE customer_id = $riderID";
        $result = $conn->query($sql);
        $result->execute();

      }
    }
  }

  //gets rider data
  $sql = "SELECT * FROM customer WHERE customer_id = $riderID";
  $result = $conn->query($sql);
  $result->execute();

  $row = $result->fetch(PDO::FETCH_ASSOC);
  $outFirst = $row['first_name'];
  $outLast = $row['last_name'];
  $outEmail = $row['email'];
  $outPhone = $row['phone_number'];
  $outBalance = $row['balance'];


  //functions that properly formats data to be tested.
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?> 
