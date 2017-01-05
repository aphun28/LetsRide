/**
 * Provides functions using Google Maps API services.
 * Includes autocomplete, places, geocoding, distance, directions
 */

var mapModel;
var map;
var placesService;
var geocoderService = new google.maps.Geocoder();
var directionsService = new google.maps.DirectionsService();
var directionsDisplay = new google.maps.DirectionsRenderer();

/**
 * Setup services with given map.
 * Must call this function before using other service functions.
 * @param {GoogleMaps} mapModel model 
 * @param {Object} map google.maps.Map
 */
function setupServices(mapModel, map) {
  this.mapModel = mapModel;
  this.map = map;
  directionsDisplay.setMap(map);
  placesService = new google.maps.places.PlacesService(map);
}

/**
 * Attaches tilesloaded Listener for map and calls callback function.
 * @param {Function} callback function to run on after finish executing
 */
function attachTilesLoadedListener(callback) {
  // wait for gmap tiles to load before executing
  google.maps.event.addListenerOnce(map, 'tilesloaded', function(e){
    console.log("Google maps loaded.");
    callback();
  });
}

/**
 * Provides autocomplete of known addresses to passed element.
 * @param {Element} element DOM element object
 * @return {Object} object google.maps.places.Autocomplete
 */
function provideAutocomplete(element) {
  return new google.maps.places.Autocomplete(element);
}

/**
 * Retrieves place details from place id and sends results to callback function.
 * @param {Number} placeID id of place
 * @param {Function} callback(google.maps.places.PlaceResult)
 */
function getPlaceDetails(placeID, callback) {
  placesService.getDetails({
    placeId: placeID
  }, function(result, status) {
    if (status === 'OK') {
      callback(result);
    } else {
      alert('getPlaceDetails failed: ' + status);
    }
  });
}

/**
 * Geocoes string address then sends results to callback function.
 * @param {String} address street address
 * @param {Function} callback(google.maps.GeocoderResult)
 */
function geocodeAddress(address, callback) {
  geocoderService.geocode({
    'address': address
  }, function(results, status) {
    if (status === 'OK') {
      // var latLng = results[0].geometry.location;
      // console.log(latLng);
      callback(results[0]);
    }
    else {
      alert('geocodeAddress failed: ' + status);
    }
  });
}

/**
 * Geocodes latitude and longitude then sends results to callback function.
 * @param {Array} latLng array with lat and lng
 * @param {Function} callback(google.maps.GeocoderResult)
 */
function geocodeLatLng(latLng, callback) {
  geocoderService.geocode({
    'location': latLng
  }, function (results, status) {
    if (status === 'OK') {
      if (results[1]) {
        callback(results[1]);
      } else {
        alert('geocodeLatLng: No results found');
      }
    } else {
      alert('geocodeLatLng failed: ' + status);
    }
  });
}

/**
 * Displays route on map given two address.
 * @param {String} pickupAddr address of pickup
 * @param {String} destAddr address destination
 */
function displayRouteByAddr(pickupAddr, destAddr) {
  directionsService.route({
    origin: pickupAddr,
    destination: destAddr,
    travelMode: 'DRIVING'
  }, function(response, status) {
    if (status === 'OK') {
      directionsDisplay.setDirections(response);
    } else {
      alert('displayRoute failed: ' + status);
    }
  });
}

/**
 * Displays route on map given two places.
 * @param {String} pickupPlaceID place id of pickup
 * @param {String} destPlaceID place id of destination
 * @param {Function} callback function
 */
function displayRoute(pickupPlaceID, destPlaceID, callback) {
  directionsService.route({
    origin: {placeId: pickupPlaceID},
    destination: {placeId: destPlaceID},
    travelMode: 'DRIVING'
  }, function(response, status) {
    if (status === 'OK') {
      directionsDisplay.setDirections(response);
      callback();
    } else {
      alert('displayRoute failed: ' + status);
    }
  });
}

function removeDisplayRoute() {
  directionsDisplay.setDirections({routes: []});
  mapModel.resetMap();
}

function setDirectionsPanel(elem) {
  directionsDisplay.setPanel(elem);
}

/**
 * Retrieves distance matrix then sends results to callback function.
 * @param {String} pickup location of pickup
 * @param {String} dest location of destination
 * @param {Function} callback(google.maps.DistanceMatrixResponseElement)
 */
function getDistanceMatrix(pickup, dest, callback) {
  // ajax call to Distance Matrix service
  // required to get estimated time with traffic
  var data = {pickup: pickup, dest: dest};
  $.post('php/getDistanceMatrix.php', data, function(results) {
    callback(results.rows[0].elements[0]);
  });

  /* Alternative version if CORS is enables */
  // $.ajax({
  //   url: 'https://maps.googleapis.com/maps/api/distancematrix/json',
  //   data: {
  //     origins: pickup,
  //     destinations: dest,
  //     departure_time: 'now',
  //     key: 'AIzaSyA77w9Xsq-kDT7gcMTdpjp_YMYtgg29YJk'
  //   },
  //   success: function (data) {
  //     console.log(data);
  //     callback(data.rows[0].elements[0]);
  //   },
  //   error: function (err) {
  //     console.log(err);
  //     alert("Error accessing Distance Matrix API: " + err);
  //   }
  // });
}
