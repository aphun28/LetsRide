<?php
  include('php/inSessionCheck.php');
  $title = 'Driver';
  include('includes/header.php');
?>
<body id="driverPage">
  <!-- Modals -->
  <?php include('html/driver-request-modal.html'); ?>
  <!-- Loading -->
  <?php include('html/loading.html'); ?>
  <!-- Navbar -->
  <?php include('includes/navbar-driver.php'); ?>
  <!-- Main Content -->
  <div id="mainContainer">
    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar -->
        <div class="col-xs-3 text-center" id="sidebar">
          <?php include('html/driver-main-sidebar.html'); ?>
        </div>
        <!-- Right Content -->
        <div class="col-xs-9" id="mainRight">
          <div id="mapCanvas"></div>
        </div>
      </div>
    </div>
  </div>
</body>
<?php include('includes/footer.php'); ?>
