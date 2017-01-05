/**
 * Loads map and attach listeners for Driver Main Page.
 */

// Execute when DOM is fully loaded
$(document).ready(function() {
  initMap();

  // On logout, set driver offline and logout
  $("#logout").on('click', function(e) {
    $.post('php/driverOffline.php', function(e2) {
      $.post('php/logout.php', function(e3) {
        window.location.href = './';
      });
    });
  });

  // On page exit, set driver offline
  window.onbeforeunload = function() { 
    $.post('php/driverOffline.php');
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
        // start worker thread
        $.post('php/driverOnline.php', gmap.myLocation, function(data, status){
          runCheckRequest();
        });
        removeLoadingDiv();
      });
    });
  }
  else {
    alert('Geolocation is not supported for this Browser/OS.');
  }
}
