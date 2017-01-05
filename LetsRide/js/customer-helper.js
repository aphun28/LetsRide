/**
 * Helper functions to handle actions for customer.
 * Includes button listeners and running threads for each state. 
 * 
 * STATES: 0 = MAIN / REQUESTING
 *         1 = IN TRANSIT / WAITING FOR DRIVER
 *         2 = RIDE / RIDING
 *         3 = RATING
 */

var worker;
var workerScript = 'js/customer-worker.js';
var sendRequestScript = 'php/customerSendRequest.php';
var cancelRequestScript = 'php/customerCancelRequest.php';
var checkApprovalScript = 'php/customerCheckApproval.php';
var checkPickupScript = 'php/customerCheckPickup.php';
var checkRideScript = 'php/customerCheckRide.php';
var submitRatingScript = 'php/customerSubmitRating.php';

var getDriverInfoScript = 'php/customerGetDriverInfo.php'
var getDriverLocationScript = 'php/customerGetDriverLocation.php'

var findingDriverModal = $('#customerRequestModal');
var requestBtn = '#requestBtn';
var cancelRequestBtn = '#cancelRequestBtn';
var cancelInTransitBtn = '#cancelInTransitBtn';
var submitRatingBtn = "#submitRatingBtn";
var ratingFormStars = 'input[name=ratingFormStars]:checked';
var ratingFormComments = '#ratingFormComments';

var REJECT_TIMEOUT = 0; // timeout when driver rejects
var requestRejectTimeout; // timeout for rejected requests


/***** STATE 0: MAIN / REQUESTING *****/

/**
 * Button Listener: sends requests to drivers.
 * Checks for valid location input before sending request.
 */
$(document).on('click', requestBtn, function(e) {
  // validate and retrieve locations
  validateAndRetrieve(function(pickupID, destID, pickupLoc, destLoc, pickupAddr, destAddr) {
    if (!pickupID || !destID || !pickupLoc || !destLoc || !pickupAddr || !destAddr) {
      alert("Invalid locations");
      return;
    }

    // find and connect with closest driver
    var rideData = { 
      pickupLat: pickupLoc.lat(), pickupLng: pickupLoc.lng(),
      destLat: destLoc.lat(), destLng: destLoc.lng(),
      pickupAddr: pickupAddr, destAddr: destAddr,
      rideFare: $('#fare').text(),
      rideDur: $('#duration').text()
    };
    sendRequest(rideData);
  });
});

/**
 * Button Listener: cancel customer's request.
 */
$(document).on('click', cancelRequestBtn, function(e) {
  $.post(cancelRequestScript, null, function(data, status) {
    console.log("Request canceled");
    terminateWorker();
    hideFindDriverModal();
  });
});

/**
 * Worker: sends request to driver and awaits reply. Finds new driver if selected driver rejected.
 * @param {Array} location data
 */
var sendRequest = function(rideData) {
  console.log("Requesting driver...");
  $.post(sendRequestScript, rideData, function(data, status) {
    console.log(data);
    if (data < 0) { // failure
      terminateWorker();
      hideFindDriverModal();
      alert("Could not find a driver. Please try again");
    }
    else { // success, found driver
      loadFindDriverModal();
      runCheckApproval(rideData);
    }
  });
}

/** 
 * Worker: checkd for approval or rejection of sent request.
 * @param {Array} location data
 */
var runCheckApproval = function(rideData) {
  // run worker to check for approval or rejection
  startWorker(checkApprovalScript);
  worker.addEventListener('message', function(e) {
    if (e.data < 0) { // driver rejected, find another driver
      console.log("Driver rejected, wait before finding new one");
      terminateWorker();
      requestRejectTimeout = setTimeout(function() { sendRequest(rideData); }, REJECT_TIMEOUT);
    }
    else if (e.data > 0) { // driver accepted
      console.log("Driver accepted!");
      terminateWorker();
      // save driver info to global variable
      $.get(getDriverInfoScript, null, function(data, status) {
        driverInfo = JSON.parse(data);
        hideFindDriverModal();
        loadInTransitPage(); // DYNAMIC LOADING
        runCheckPickup();
      });
    }
  }, false);
}


/***** STATE 1: IN TRANSIT / WAITING FOR DRIVER *****/

/**
 * Button Listener: cancels in transit with driver.
 */
$(document).on('click', cancelInTransitBtn, function(e) {
  console.log("Canceled in transit");
  $.post(cancelRequestScript, null, function(data, status) {
    terminateWorker();
    loadMainPage(); // DYNAMIC LOADING
  });
});

/**
 * Worker: checks if driver confirmed or canceled pickup.
 */
var runCheckPickup = function() {
  startWorker(checkPickupScript);
  worker.addEventListener('message', function(e) {
    if (e.data < 0) { // driver canceled
      console.log("Driver canceled pickup.");
      terminateWorker();
      alert("Driver canceled ride");
      loadMainPage(); // DYNAMIC LOADING
    }
    else if (e.data > 0) { // driver pick up
      console.log("Driver confirmed pickup!");
      terminateWorker();
      loadRidePage(); // DYNAMIC LOADING
      runCheckRide();
    }
    else { // track driver's coordinates
      $.get(getDriverLocationScript, null, function(data, status) {
        var coord = JSON.parse(data);
        gmap.setDriverMarker({lat: parseFloat(coord.lat), lng: parseFloat(coord.lng)});
      });
    }
  });
}

/***** STATE 2: RIDE / RIDING *****/

/**
 * Worker: checks if ride is completed.
 */
var runCheckRide = function() {
  startWorker(checkRideScript);
  worker.addEventListener('message', function(e) {
    if (e.data > 0) { // ride completed
      console.log("Ride completed!");
      terminateWorker();
      loadRatingPage(); // DYNAMIC LOADING
    }
  });
}

/***** STATE 3: RATING *****/

/**
 * Button Listener: complete rating.
 */
$(document).on('click', submitRatingBtn, function(e) {
  var ratingStars = $(ratingFormStars).val();
  var ratingComments =  $(ratingFormComments).val();

  // check for selected rating
  if (ratingStars === null || ratingStars === undefined) {
    alert("Please select a rating");
  }
  else {
    var rating = {
      stars: ratingStars,
      comments: ratingComments
    };
    $.post(submitRatingScript, rating, function(data, status) {
      console.log("Rating submitted!")
      terminateWorker();
      window.location.href = "rider.php"; // LOAD NEW PAGE
    });
  }
});

/***** WORKER HELPER FUNCTIONS *****/

/**
 * Starts worker.
 * @param {String} location of script
 */
var startWorker = function(scriptToRun) {
  worker = new Worker(workerScript);
  worker.postMessage(scriptToRun);
}

/**
 * Terminates ongoing worker.
 */
var terminateWorker = function() {
  if (worker !== undefined) {
    worker.terminate();
    worker = undefined;
  }
 if (requestRejectTimeout !== undefined) {
    clearTimeout(requestRejectTimeout);
  }
}