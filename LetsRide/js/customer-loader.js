/**
 * Loads html pages for customer.
 */

// Main divs
var sidebar = $('#sidebar');
var mainRight = $('#mainRight');
var statusBar = $('.status-bar');
var statusText = $('.status-text');

// Modals
var findingDriverModal = $('#customerRequestModal');

// Sidebar html
var mainSidebar = 'html/customer-main-sidebar.html';
var mainRideInfo = 'html/customer-main-ride-info.html';
var inTransitSidebar = 'html/customer-intransit-sidebar.html';
var rideSidebar = 'html/customer-ride-sidebar.html';
var ratingSidebar = 'html/rating-sidebar.html';
var ratingForm = 'html/rating-form.html';


function loadMainPage() {
  console.log("Load Main Page");
  sidebar.empty();
  sidebar.load(mainSidebar, function() {
    reloadMainComponents();
  });
  removeDisplayRoute();
  gmap.removeDriverMarker();
  statusBar.hide();
}

function loadInTransitPage() {
  console.log("Load In Transit Page");
  sidebar.empty();
  sidebar.load(inTransitSidebar, function() {
    if (driverInfo.picture !== null) {
      $('#itDriverImage').html(driverInfo.picture);
    }
    $('#itDriverName').html(driverInfo.name);
    $('#itPickupAddr').html(driverInfo.pickupAddr);
    displayRouteByAddr(gmap.myLocation, driverInfo.pickupAddr);
  });
  statusBar.show();
  statusText.html("Wating For Driver at Pickup Location");
}

function loadRidePage() {
  console.log("Load Ride Page");
  sidebar.empty();
  sidebar.load(rideSidebar, function() {
    if (driverInfo.picture !== null) {
      $('#rideDriverImage').html(driverInfo.picture);
    }
    $('#rideDriverName').html(driverInfo.name);
    $('#rideDestAddr').html(driverInfo.destAddr);
    displayRouteByAddr(gmap.myLocation, driverInfo.destAddr)
  });
  gmap.removeDriverMarker();
  statusBar.show();
  statusText.html("Riding to Destination");
}

function loadRatingPage(){
  console.log("Load Rating Page");
  sidebar.empty();
  sidebar.load(ratingSidebar, function() {
    if (driverInfo.picture !== null) {
      $('#ratingImage').html(driverInfo.picture);
    }
    $('#ratingName').html(driverInfo.name);
    // $('#ratingStars').html();
    var avgRating = driverInfo.avgRating;
    if (String(driverInfo.avgRating).length < 5) {
      avgRating = driverInfo.avgRating + " / 5";
    }
    $('#ratingAverage').html(avgRating);
  })
  mainRight.load(ratingForm);
  statusBar.show();
  statusText.html("Rate Your Driver");
}

function loadFindDriverModal() {
  findingDriverModal.modal('show');
}

function hideFindDriverModal() {
  findingDriverModal.modal('hide');
}

function loadRideInfo() {
  $('#rideInfo').empty();
  $('#rideInfo').load('html/customer-main-ride-info.html');
}