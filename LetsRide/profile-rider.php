<?php
  include('php/inSessionCheck.php');
  include('php/profileUpdateRider.php');
  $title = 'Rider Profile';
  include('includes/header.php');
?>
<body id="profileRiderUpdate">
  <!-- Back Bar -->
  <a class="profile-header" href="rider.php">
    <i class="fa fa-chevron-left" aria-hidden="true"></i> Back to Rider Page
  </a>
  <div class="reg-container">
    <!-- Greet Rider -->
    <h1 class="reg-title text-center">Hello <?php echo $outFirst . " " . $outLast ?>!</h1>
    <h4 class="reg-title text-center">Account Type: Rider</h4>
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
  </div>
</body>
<?php include('includes/footer.php'); ?>
