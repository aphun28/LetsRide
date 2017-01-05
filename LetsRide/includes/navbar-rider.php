<nav class="navbar navbar-default navbar-static-top main-navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="rider.php">Let's Ride</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <p class="navbar-text">Signed in as <?php echo $_SESSION['customer_first_name'] . " " . $_SESSION['customer_last_name']; ?></p>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile-rider.php"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
        <li><a id="logout" href="#"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
      </ul>
    </div>
  </div>
  <div class="status-bar">
    <div class="animate-flicker status-text">Status</div>
  </div>
</nav>