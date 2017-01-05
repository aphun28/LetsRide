 <?php
  /**
   * Registers new Rider account.
   */

  include_once '_globals.php';
  include 'connectDB.php';

  // define variables and set to empty values
  $coid = $sid = $ciid = $aid = $first = $last = $email = $password = $phone = $country = $state = $city = $address = $postal = ""; 

  $first = $_SESSION["first"];
  $last = $_SESSION["last"];
  $email = $_SESSION["email"];
  $pass = $_SESSION["password"];
  $phone = $_SESSION["phone"];

  // create new rider
  $query = "INSERT INTO customer (first_name, last_name, email, phone_number, password) " .
      "VALUES (:fn, :ln, :em, :ph, :pa);";
  $result = $conn->prepare($query);
  $result->bindParam(':fn', $first);
  $result->bindParam(':ln', $last);
  $result->bindParam(':em', $email);
  $result->bindParam(':ph', $phone);
  $result->bindParam(':pa', $pass);
  $result->execute();

  // end session and redirect to success page
  endSession();
  header('Location: ' . $registerSuccessURL);
?> 