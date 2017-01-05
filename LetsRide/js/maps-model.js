/**
 * Model object for Google Maps holds map and user location.
 * New object creates map, finds user's current location, and marks map.
 */

function GoogleMaps() {
  this.mapOptions = {
    zoom: 15,
    disableDefaultUI: true,
    zoomControl: true
  };
  this.mapElement = document.getElementById('mapCanvas');
  // this.myLocation = {lat: 37.335142, lng: -121.881276};
  this.myLocation = {};
  this.myMap = new google.maps.Map(this.mapElement, this.mapOptions);

  this.markerOptions = {
    icon: {
      path: google.maps.SymbolPath.CIRCLE,
      scale: 5,
      strokeColor: 'navy'
    },
    map: this.myMap
  };
  this.myMarker = new google.maps.Marker(this.markerOptions);
  this.watchID = 0;

  // other properties for customer
  this.driverMarker = new google.maps.Marker({
    icon: "images/logo-small.png"
  });

  // find current position then track user
  this.findMe();
  this.trackMe();
}

GoogleMaps.prototype.resetMap = function() {
  this.myMap.setZoom(15);
  this.myMap.setCenter(this.myLocation);
}

GoogleMaps.prototype.setDriverMarker = function(latLng) {
  this.driverMarker.setPosition(latLng);
  this.driverMarker.setMap(this.myMap);
}

GoogleMaps.prototype.removeDriverMarker = function(latLng) {
  this.driverMarker.setMap(null);
}


/**
 * Center and mark current position on map.
 */
GoogleMaps.prototype.findMe = function(callback) {
  var options = {
    enableHighAccuracy: true,
    timeout: 5000
  };

  navigator.geolocation.getCurrentPosition((pos) => {
      this.myLocation = {lat: pos.coords.latitude, lng: pos.coords.longitude};
      this.myMap.setCenter(this.myLocation);
      this.myMarker.setPosition(this.myLocation);
    }, (err) => {
      this.positionErrorHandler(err, 'GoogleMaps.findMe()');
      if (err.code != err.PERMISSION_DENIED && err.code != err.POSITION_UNAVAILABLE) {
       this.findMe(); // try again if failed
      }
      else {
        alert("Please enable location services on this device and refresh the page.");
      }
    }, options);
}

/**
 * Tracks current location and sets marker. Doesn't center map.
 */
GoogleMaps.prototype.trackMe = function() {
  var options = {
    enableHighAccuracy: true,
    timeout: 10000
  };

  // Automatically executes each time the position of the device changes
  watchID = navigator.geolocation.watchPosition((pos) => {
      console.log("Currently tracking user...");
      this.myLocation = {lat: pos.coords.latitude, lng: pos.coords.longitude};
      this.myMarker.setPosition(this.myLocation);
    }, (err) => {
      this.positionErrorHandler(err, 'GoogleMaps.trackMe()');
    }, options);
}

/**
 * Handles position errors.
 * @param error type of error
 * @param funcName name of function that caused error
 */
GoogleMaps.prototype.positionErrorHandler = function(error, funcName) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      console.log(funcName + " : " + error.message);
      break;
    case error.POSITION_UNAVAILABLE:
      console.log(funcName + " : " + error.message);
      break;
    case error.TIMEOUT:
      console.log(funcName + " : " + error.message);
      break;
    default:
      console.log(funcName + " : " + error.message);
  }
}
