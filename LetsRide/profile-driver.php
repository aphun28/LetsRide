<?php
  include('php/inSessionCheck.php');
	include('php/profileUpdateDriver.php');
  $title = 'Driver Profile';
  include('includes/header.php');
?>
<body id="profileDriverUpdate">
  <!-- Back Bar -->
  <a class="profile-header" href="driver.php">
    <i class="fa fa-chevron-left" aria-hidden="true"></i> Back to Driver Page
  </a>
  <div class="reg-container">
    <!-- Greet Driver -->
    <h1 class="reg-title text-center">Hello <?php echo $outFirst . " " . $outLast ?>!</h1>
    <h4 class="reg-title text-center">Account Type: Driver</h4>
    <!-- Update Email Form --> 
    <form class="reg-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
      <div class="form-group">
        <label for="email">Email</label>
        <span class="reg-form-error pull-right"> <?php echo $emailErr;?></span>
        <input type="text" class="form-control" name="email" placeholder="<?php echo $outEmail; ?>">
      </div>
      <div class="form-group">
        <button class="btn btn-primary" type="submit">Update Email</button>
      </div>
    </form>
    <!-- Update Phone Number Form -->
    <form class="reg-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
      <div class="form-group">
        <label for="phonenumber">Phone Number</label>
        <span class="reg-form-error pull-right"> <?php echo $pnumErr;?></span>
        <input type="text" class="form-control" name="phone"  maxlength="10"  placeholder="<?php echo $outPhone; ?>">
      </div>
      <div class="form-group">
        <button class="btn btn-primary" type="submit">Update Phone Number</button>
      </div>
    </form>
    <!-- Update Password Form -->
    <form class="reg-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
      <div class="form-group">
        <label for="password">Password</label>
        <span class="reg-form-error pull-right"> <?php echo $passErr;?></span>
        <input type="password" class="form-control" name="pass" placeholder="**********">
      </div>
      <div class="form-group">
        <button class="btn btn-primary" type="submit">Update Password</button>
      </div>
    </form>
    <hr />
    <!-- Update Car Form -->
    <form class="reg-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
      <div class="form-group">
        <label for="carmake">Car Make</label>
        <span class="reg-form-error pull-right"> <?php echo $makeErr;?></span>
        <input type="text" class="form-control" name="make" placeholder="<?php echo $make;?>">
      </div>
      <div class="form-group">
        <label for="carmodel">Car Model</label>
        <span class="reg-form-error pull-right"> <?php echo $modelErr;?></span>
        <input type="text" class="form-control" name="model" placeholder="<?php echo $model;?>">
      </div>
      <div class="form-group">
        <label for="caryear">Car Year</label>
        <span class="reg-form-error pull-right"> <?php echo $yearErr;?></span>
        <input type="text" class="form-control" name="year" placeholder="<?php echo $year;?>" maxlength="4">
      </div>
      <div class="form-group">
        <label for="carcolor">Car Color</label>
        <span class="reg-form-error pull-right"> <?php echo $colorErr;?></span>
        <input type="text" class="form-control" name="color" placeholder="<?php echo $color;?>">
      </div>
      <div class="form-group">
        <label for="licenseplate">License Plate</label>
        <span class="reg-form-error pull-right"> <?php echo $plateErr;?></span>
        <input type="text" class="form-control" name="plate" placeholder="<?php echo $plate;?>" maxlength="7">
      </div>
      <div class="form-group">
        <button class="btn btn-primary" type="submit" name="carForm">Update Car Information</button>
      </div>
    </form>
  </div>
</body>
<?php include('includes/footer.php'); ?>
