<?php
  include('php/registerValidateDriver.php');
  $title = 'Register as Driver';
  include('includes/header.php');
?>
<body id="registerDriverPage">
  <div class="reg-container"> 
    <h1 class="reg-title text-center">Sign Up To Drive</h1>
    <form class="reg-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
      <div class="form-group">
        <label for="firstname">First Name</label>
        <span class="reg-form-error pull-right"> <?php echo $fnameErr;?></span>
        <input type="text" class="form-control" name="first" placeholder="First Name" value="<?php echo $fname;?>">
      </div>
      <div class="form-group">
        <label for="lastname">Last Name</label>
        <span class="reg-form-error pull-right"> <?php echo $lnameErr;?></span>
        <input type="text" class="form-control" name="last" placeholder="Last Name" value="<?php echo $lname;?>">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <span class="reg-form-error pull-right"> <?php echo $emailErr;?></span>
        <input type="text" class="form-control"name="email" placeholder="name@email.com" value="<?php echo $email;?>">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <span class="reg-form-error pull-right"> <?php echo $passErr;?></span>
        <input type="password" class="form-control"name="password" placeholder="You better remember this" value="<?php echo $pass;?>">
      </div>
      <div class="form-group">
        <label for="phonenumber">Phone Number</label>
        <span class="reg-form-error pull-right"> <?php echo $pnumErr;?></span>
        <input type="text" class="form-control" name="phone" placeholder="1234567890" maxlength="10" value="<?php echo $pnumber;?>">
      </div>
      <!-- 
      Country: <input type="text" name="country"><br>
      City: <input type="text" name="city"><br>
      Address: <input type="text" name="address"><br>
      Postal Code: <input type="text" name="postal"><br>
      -->
      <hr />
      <!--<div class="form-group">
        <label for="driverlicense">Driver's License #:</label>
        <span class="reg-form-error pull-right"> <?php echo $licenseErr;?></span>
        <input type="text" class="form-control" name="dlicense" maxlength="8" value="<?php echo $dlicense;?>">
      </div>-->
      <div class="form-group">
        <label for="carmake">Car Make</label>
        <span class="reg-form-error pull-right"> <?php echo $makeErr;?></span>
        <input type="text" class="form-control" name="make" placeholder="Honda" value="<?php echo $make;?>">
      </div>
      <div class="form-group">
        <label for="carmodel">Car Model</label>
        <span class="reg-form-error pull-right"> <?php echo $modelErr;?></span>
        <input type="text" class="form-control" name="model" placeholder="Civic" value="<?php echo $model;?>">
      </div>
      <div class="form-group">
        <label for="caryear">Car Year</label>
        <span class="reg-form-error pull-right"> <?php echo $yearErr;?></span>
        <input type="text" class="form-control" name="year" placeholder="2016" maxlength="4" value="<?php echo $year;?>">
      </div>
      <div class="form-group">
        <label for="carcolor">Car Color</label>
        <span class="reg-form-error pull-right"> <?php echo $colorErr;?></span>
        <input type="text" class="form-control" name="color" placeholder="Silver" value="<?php echo $color;?>">
      </div>
      <div class="form-group">
        <label for="licenseplate">License Plate</label>
        <span class="reg-form-error pull-right"> <?php echo $plateErr;?></span>
        <input type="text" class="form-control" name="plate" placeholder="1ABC234" maxlength="7" value="<?php echo $plate;?>">
      </div>
      <div class="form-group">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Create Driver Account</button>
      </div>
    </form>
    <!-- Back to Home Page -->
    <p class="text-center"><a href="./">Go back to home page.</a></p>
  </div>
</body>
<?php include('includes/footer.php'); ?>

