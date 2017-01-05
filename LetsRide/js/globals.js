/**
 * Global variables and functions available on all pages.
 */

// GLOBAL VARIABLES
var gmap;
var customerInfo; // for driver to hold customer info
var driverInfo; // for customer to hold driver info


// GLOBAL FUNCTIONS

/* DRIVER/RIDER SHARED MAIN FUNCTIONS */

/**
 * Creates google maps and setup map services.
 * @param {Function} callback function
 */
var setupGoogleMaps = function(callback) {
  initGoogleMaps(function() {
    setupServices(gmap, gmap.myMap);
    google.maps.event.addDomListener(window, "resize", function() {
      var center = gmap.myMap.getCenter();
      google.maps.event.trigger(gmap.myMap, "resize");
      gmap.myMap.setCenter(center); 
    });
    callback();
  });
}

var initGoogleMaps = function(callback) {
  gmap = new GoogleMaps();
  callback();
}

/**
 * Removes loading div by slow fade out.
 */
var removeLoadingDiv = function() {
  $("#loading").fadeOut("slow", function() {
      $(this).remove();
  });
}