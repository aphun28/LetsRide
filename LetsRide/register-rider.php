<?php
  include('php/registerValidateRider.php');
  $title = 'Register as Rider';
  include('includes/header.php');
?>
<body id="registerRiderPage">
  <div class="reg-container">
    <h1 class="reg-title text-center">Sign Up To Ride</h1>
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
      State: <input type="text" name="state"><br>
      City: <input type="text" name="city"><br>
      Address: <input type="text" name="address"><br>
      Postal Code: <input type="text" name="postal"><br>
      -->
      <div class="form-group">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Create Rider Account</button>
      </div>
      <!-- Back to Home Page -->
      <p class="text-center"><a href="./">Go back to home page.</a></p>
    </form>
  </div>
</body>
<?php include('includes/footer.php'); ?>
