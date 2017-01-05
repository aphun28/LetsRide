/**
 * Helper functions to handle actions for driver.
 * Includes button listeners and running threads for each state.
 *  
 * STATES: 0 = MAIN / WAITING FOR REQUEST
 *         1 = IN TRANSIT / PICKING UP
 *         2 = RIDE / DRIVING
 *         3 = RATING
 */

var worker;
var workerScript = 'js/driver-worker.js';
var onlineScript = 'php/driverOnline.php';
var offlineScript = 'php/driverOffline.php';
var acceptRequestScript = 'php/driverAcceptRequest.php';
var rejectRequestScript = 'php/driverRejectRequest.php';
var checkRequestScript = 'php/driverCheckRequest.php';
var checkCancelScript = 'php/driverCheckCancel.php';
var confirmPickupScript = 'php/driverConfirmPickup.php';
var completeRideScript = 'php/driverCompleteRide.php';
var submitRatingScript = 'php/driverSubmitRating.php';

var getCustomerInfoScript = 'php/driverGetCustomerInfo.php'
var updateLocationScript = 'php/driverUpdateLocation.php';

var acceptRequestBtn = '#acceptRequestBtn';
var rejectRequestBtn = '#rejectRequestBtn';
var cancelInTransitBtn = '#cancelInTransitBtn';
var confirmPickBtn = '#confirmPickupBtn';
var completeRideBtn = '#completeRideBtn';
var submitRatingBtn = "#submitRatingBtn";
var ratingFormStars = 'input[name=ratingFormStars]:checked';
var ratingFormComments = '#ratingFormComments';

var REJECT_TIMEOUT = 5000; // time until check request after rejecting customer
var CANCEL_TIMEOUT = 2000; // time until check request after customer cancelled

/**
 * Updates location of driver in database based on current coordinates.
 */
var updateLocation = function() {
  $.post(updateLocationScript, gmap.myLocation);
}

var setDriverOffline = function() {
  $.post('php/driverOffline.php');
} 

var setDriverOnline = function(callback) {
  $.post('php/driverOnline.php', gmap.myLocation, function(data, status){
    callback();
  });
}


/***** STATE 0: MAIN / WAITING FOR REQUEST *****/

/**
 * Button Listener: accept customer request.
 */
$(document).on('click', acceptRequestBtn, function(e) {
  $.post(acceptRequestScript, null, function(data, status) {
      console.log("Request accepted");
      terminateWorker();
      hideRequestModal(); // DYNAMIC LOADING
      loadInTransitPage(); // DYNAMIC LOADING
      runCheckInTransitCancel();
  });
});

/**
 * Button Listener: reject customer request. Timeout penalty applied.
 */
$(document).on('click', rejectRequestBtn, function(e) {
  $.post(rejectRequestScript, null, function(data, status) {
    console.log("Request rejected");
    terminateWorker();
    hideRequestModal(); // DYNAMIC LOADING
    setDriverOffline();
    setTimeout(function() { 
      setDriverOnline(function() { 
        runCheckRequest(); 
      });
    }, REJECT_TIMEOUT);
  });
});



/**
 * Worker: checks for sent requests from customer.
 */
var runCheckRequest = function() {
  terminateWorker();
  startWorker(checkRequestScript);
  worker.addEventListener('message', function(e) {
    if (e.data > 0) {  // request found
      terminateWorker();
      // Save customer information to global variable
      $.get(getCustomerInfoScript, null, function(data, status) {
        customerInfo = JSON.parse(data);
        loadRequestModal(); // DYNAMIC LOADING
        runCheckCancel(); 
      });
    }
    updateLocation();
  }, false);
}

/**
 * Worker: checks if customer cancels request.
 */
var runCheckCancel = function() {
  startWorker(checkCancelScript);
  worker.addEventListener('message', function(e) {
    if (e.data > 0) { // customer canceled
      terminateWorker();
      hideRequestModal(); // DYNAMIC LOADING
      // changeStatus(0);
      setTimeout(function() { runCheckRequest(); }, CANCEL_TIMEOUT);
    }
  });
}


/***** STATE 1: IN TRANSIT / PICKING UP *****/

/**
 * Button Listener: cancel customer pickup.
 */
$(document).on('click', cancelInTransitBtn, function(e) {
  $.post(rejectRequestScript, null, function(data, status) {
    console.log("Canceled in transit");
    terminateWorker();
    loadMainPage(); // DYNAMIC LOADING
    setDriverOffline();
    setTimeout(function() { 
      setDriverOnline(function() { 
        runCheckRequest(); 
      });
    }, REJECT_TIMEOUT);  });
});

/**
 * Button Listener: confirm customer pickup.
 */
$(document).on('click', confirmPickBtn, function(e) {
  $.post(confirmPickupScript, null, function(data, status) {
    console.log("Confirmed customer pickup")
    terminateWorker();
    loadRidePage(); // DYNAMIC LOADING
  });
});


/**
 * Worker: check if customer cancels pickup request.
 */
var runCheckInTransitCancel = function() {
  startWorker(checkCancelScript);
  worker.addEventListener('message', function(e) {
    if (e.data > 0) { // customer canceled
      console.log("Customer canceled request");
      terminateWorker();
      alert("Rider canceled ride");
      loadMainPage(); // DYNAMIC LOADING
      setTimeout(function() { runCheckRequest(); }, CANCEL_TIMEOUT);
    }
    updateLocation();
  });
}

/***** STATE 2: RIDE / DRIVING *****/

/**
 * Button Listener: complete ride.
 */
$(document).one('click', completeRideBtn, function(e) {
  $.post(completeRideScript, null, function(data, status) {
    console.log("Ride completed!")
    terminateWorker();
    loadRatingPage(); // DYNAMIC LOADING
  });
});


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
      window.location.href = "driver.php"; // LOAD NEW PAGE
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
}