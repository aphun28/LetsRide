/**
 * Loads html pages for driver and prefills with content.
 */

// Main divs
var sidebar = $('#sidebar');
var mainRight = $('#mainRight');
var statusBar = $('.status-bar');
var statusText = $('.status-text');

// Modals 
var requestModal = $('#driverRequestModal');

// Sidebar html
var mainSidebar = 'html/driver-main-sidebar.html';
var inTransitSidebar = 'html/driver-intransit-sidebar.html';
var rideSidebar = 'html/driver-ride-sidebar.html';
var ratingSidebar = 'html/rating-sidebar.html';
var ratingForm = 'html/rating-form.html';


function loadMainPage() {
  console.log("Load Main Page");
  sidebar.empty();
  sidebar.load(mainSidebar);
  removeDisplayRoute();
  statusBar.hide();
}

function loadInTransitPage() {
  console.log("Load In Transit Page");
  sidebar.empty();
  sidebar.load(inTransitSidebar, function() {
    if (customerInfo.picture !== null) {
      $('#itCustomerImage').html(customerInfo.picture);
    }
    $('#itCustomerName').html(customerInfo.name);
    $('#itPickupAddr').html(customerInfo.pickupAddr);
    displayRouteByAddr(gmap.myLocation, customerInfo.pickupAddr);
  });
  statusBar.show();
  statusText.html("Driving to Pickup Location");
}

function loadRidePage() {
  console.log("Load Ride Page");
  sidebar.empty();
  sidebar.load(rideSidebar, function() {
    if (customerInfo.picture !== null) {
      $('#rideCustomerImage').html(customerInfo.picture);
    }
    $('#rideCustomerName').html(customerInfo.name);
    $('#rideDestAddr').html(customerInfo.destAddr);
    displayRouteByAddr(gmap.myLocation, customerInfo.destAddr);
  });
  statusBar.show();
  statusText.html("Driving to Destination");
}

function loadRatingPage(){
  console.log("Load Rating Page");
  sidebar.empty();
  sidebar.load(ratingSidebar, function() {
    if (customerInfo.picture !== null) {
      $('#ratingImage').html(customerInfo.picture);
    }
    $('#ratingName').html(customerInfo.name);
    // $('#ratingStars').html();
    var avgRating = customerInfo.avgRating;
    if (String(customerInfo.avgRating).length < 5) {
      avgRating = customerInfo.avgRating + " / 5";
    }
    $('#ratingAverage').html(avgRating);
  });
  mainRight.load(ratingForm);
  statusBar.show();
  statusText.html("Rate Your Rider");
}


function loadRequestModal() {
  if (customerInfo.picture !== null) {
    $('#rmCustomerImage').html(customerInfo.picture);
  }
  $('#rmCustomerName').html(customerInfo.name);
  var avgRating = customerInfo.avgRating;
  if (String(customerInfo.avgRating).length < 5) {
    avgRating = customerInfo.avgRating + " / 5";
  }
  $('#rmRating').html(avgRating);
  $('#rmPickupAddr').html(customerInfo.pickupAddr);
  $('#rmDestAddr').html(customerInfo.destAddr);
  getDistanceMatrix(customerInfo.pickupAddr, customerInfo.destAddr, function(result) {
    $('#rmTime').html(result.duration_in_traffic.text);
  });
  displayRouteByAddr(customerInfo.pickupAddr, customerInfo.destAddr);
  requestModal.modal('show');
}

function hideRequestModal() {
  requestModal.modal('hide');
  removeDisplayRoute();
}