<?php
  include('php/loginCheck.php');
  include('includes/header.php');
?>
<body id="homePage">
  <!-- Login Modals -->
  <?php 
    include('html/home-driver-login-modal.html');
    include('html/home-rider-login-modal.html');
  ?>
  <!-- Site Banner -->
  <div id="homeBanner">
    <div id="homeHeader">
      <h1 class="home-app-name">Let's Ride</h1>
      <h3 class="home-app-desc">Bay Area Ride Shuttle Service</h3>
    </div>
    <div id="homeAccount">
      <div class="row">
        <div class="col-md-6 form-group">
          <button id="loginDriverBtn" type="button" class="btn btn-default btn-lg home-login-button" data-toggle="modal" data-target="#driverLoginModal">Login as Driver</button><br />
          <a href="register-driver.php">Create Driver Account</a>
        </div>
        <div class="col-md-6 form-group">
          <button id="loginRiderBtn" type="button" class="btn btn-default btn-lg home-login-button" data-toggle="modal" data-target="#riderLoginModal">Login as Rider</button><br />
          <a href="register-rider.php">Create Rider Account</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Main Content -->
  <div id="home-main-content">
    <section>
      <h2 class="section-title">Why Use Let's Ride?</h2>
      <div class="row">
        <div class="col-sm-4 text-center form-group">
          <img src="images/home-money.png" class="img-responsive why-icon" alt="Better rates than Lyft and Uber.">
          <h4 class="section-subtitle">Better rates than Lyft and Uber.</h4>
        </div>
        <div class="col-sm-4 text-center form-group">
          <img src="images/home-ratings.png" class="img-responsive why-icon" alt="Ratings for both Drivers and Riders.">
          <h4 class="section-subtitle">Ratings for both Drivers and Riders.</h4>
        </div>
        <div class="col-sm-4 text-center form-group">
          <img src="images/home-community.png" class="img-responsive why-icon" alt="Community focused in the Bay Area.">
          <h4 class="section-subtitle">Community focused in the Bay Area.</h4></div>
      </div>
    </section>
  </div>
  <!-- Footer -->
  <footer>
    &copy; All Rights Reserved. This is not a real website. We are not liable for injuries received by riders or drivers.
    We are not affiliated with, nor do we like the following related companies: Lyft and Uber. Stop calling us about them.
  </footer>
</body>
<?php include('includes/footer.php'); ?>
