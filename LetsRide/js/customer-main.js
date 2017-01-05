/**
 * Loads map and attach listeners for Customer Main Page.
 */

// Execute when DOM is fully loaded
$(document).ready(function() {
  initMap();
  
  // On logout
  $("#logout").on('click', function(e) {
    $.post('php/logout.php', function(e2) {
      window.location.href = './';
    });
  });

  // On page exit
  window.onbeforeunload = function() { 
    $.post('php/customerCancelRequest.php');
  };
});

/**
 * Initialize gmap and user interface.
 */
function initMap() {
  // check for Geolocation support
  if (navigator.geolocation) {
    console.log('Geolocation is supported!');

    // create maps and setup services
    setupGoogleMaps(function() {
      attachTilesLoadedListener(function() {
        // prefill current location as pickup location
        geocodeLatLng(gmap.myLocation, function(result) {
          $('#pickupInput').val(result.formatted_address);
        });
        removeLoadingDiv();
      });

      // provide autocomplete places for input fields
      // no var = global variable
      acPickup = provideAutocomplete(document.getElementById('pickupInput'));
      acDest = provideAutocomplete(document.getElementById('destinationInput'));

      // add listeners on autocomplete place change
      acPickup.addListener('place_changed', placeChangedListener);
      acDest.addListener('place_changed', placeChangedListener);
    });
  }
  else {
    alert('Geolocation is not supported for this Browser/OS.');
  }
}

/**
 * Listener for place changes on autocomplete objects.
 * Changes will display route and calculate distance matrix.
 */
var placeChangedListener = function() {
  // var requestBtn = $('#requestBtn');
  // requestBtn.addClass('disabled');
  // requestBtn.prop('disabled', true);

  // validate inputs before performing gmap actions
  validateAndRetrieve(function(pickupID, destID, pickupLoc, destLoc) {
    if (!pickupID || !destID || !pickupLoc || !destLoc) {
      return;
    }
    else {
      loadRideInfo();
      // show route
      displayRoute(pickupID, destID, function() {

        // show distance, duration, and fare based on points
        getDistanceMatrix(pickupLoc.toUrlValue(), destLoc.toUrlValue(),
          function(result) {
            // fill data
            var distance = result.distance;
            var duration = result.duration_in_traffic;
            $('#distance').html(distance.text);
            $('#duration').html(duration.text);
            var cost = ((distance.value * 0.0003) + (duration.value * 0.0003));
            var roundedCost = Math.round(cost*100)/100;
            $('#currency').html('$');
            $('#fare').html(roundedCost);
            
            // enabled request button
            // requestBtn.removeClass('disabled');
            // requestBtn.prop('disabled', false);
          });
        });
    }
  });
}

/**
 * Validate and retrieves best inputs.
 * Sends back place ids, coordinates and addresses.
 * @param {Function} callback(String, String, LatLng, LatLng, String, String)
 */
var validateAndRetrieve = function(callback) {
  var pPlace = acPickup.getPlace();
  var dPlace = acDest.getPlace();
  var pInput = $('#pickupInput').val();
  var dInput = $('#destinationInput').val();

  // continue only if both inputs have value
  if (pInput.trim() == '' || dInput.trim() == '') {
    // alert("Incomplete location fields");
    return;
  }

  // find geolocation of input values
  geocodeAddress(pInput, function(pResult) {
    geocodeAddress(dInput, function(dResult) {
      // set results from input values
      var pickupID = pResult.place_id;
      var destID = dResult.place_id;
      var pickupLoc = pResult.geometry.location;
      var destLoc = dResult.geometry.location;
      var pickupAddr = pResult.formatted_address;
      var destAddr = dResult.formatted_address;

      // use place for better accuracy if exists
      if (pPlace) {
        pickupID = pPlace.place_id;
        pickupLoc = pPlace.geometry.location;
        pickupAddr = pPlace.formatted_address;
      }
      if (dPlace) {
        destID = dPlace.place_id;
        destLoc = dPlace.geometry.location;
        destAddr = dPlace.formatted_address;
      }

      // run callback function
      callback(pickupID, destID, pickupLoc, destLoc, pickupAddr, destAddr);
    })
  });
}

/**
 * Reloads main components when reloading page.
 */
var reloadMainComponents = function() {
    geocodeLatLng(gmap.myLocation, function(result) {
      $('#pickupInput').val(result.formatted_address);
    });
    acPickup = provideAutocomplete(document.getElementById('pickupInput'));
    acDest = provideAutocomplete(document.getElementById('destinationInput'));
    acPickup.addListener('place_changed', placeChangedListener);
    acDest.addListener('place_changed', placeChangedListener);
}
