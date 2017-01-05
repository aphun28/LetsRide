<?php include_once 'php/_config.php' ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Let's Ride <?php if(isset($title)) echo " | $title"; ?></title>
    <link rel="icon" type="image/ico" href="images/favicon.ico">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="libs/bootstrap.min.css">
    <link rel="stylesheet" href="libs/bootstrap-theme.min.css">
    <link rel="stylesheet" href="libs/font-awesome.min.css">
    <link rel="stylesheet" href="libs/animate.css">

    <!-- JS Libraries -->
    <script defer src="libs/jquery-3.1.1.min.js"></script>
    <script defer src="libs/bootstrap.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">

    <!-- Google Maps API -->
    <script defer src="https://maps.googleapis.com/maps/api/js?v=3&key=<?php echo $API_KEY ?>&libraries=places"></script>

    <!-- Custom CSS and Scripts -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/home-page.css">
    <link rel="stylesheet" href="css/register-page.css">
    <link rel="stylesheet" href="css/main-page.css">
    <link rel="stylesheet" href="css/navbar-custom.css">
    <script defer src="js/loader.js"></script>
  </head>
