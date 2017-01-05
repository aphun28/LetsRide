/**
 * loader.js
 * Loads specific js scripts for each page.
 * Pages must use id attribute in body tag.
 */

var globals = 'js/globals.js';
var loginScript = 'js/login-script.js';

var resizeMap = 'js/resize-map.js';
var mapsModel = 'js/maps-model.js';
var mapsService = 'js/maps-service.js';

var customerMain = 'js/customer-main.js';
var customerLoader = 'js/customer-loader.js';
var customerHelper = 'js/customer-helper.js';

var driverMain = 'js/driver-main.js';
var driverLoader = 'js/driver-loader.js';
var driverHelper = 'js/driver-helper.js';


$(document).ready(function() {
  $.getScript(globals); // Global script for all pages

  // Home Page
  if ($('body#homePage').length) {
    $.getScript(loginScript);
  }
  // Customer Main Page
  else if ($('body#riderPage').length) {
    $.getScript(resizeMap);
    $.getScript(mapsModel);
    $.getScript(mapsService);
    $.getScript(customerLoader);
    $.getScript(customerMain);
    $.getScript(customerHelper);
  }
  // Driver Main Page
  else if ($('body#driverPage').length) {
    $.getScript(resizeMap);
    $.getScript(mapsModel);
    $.getScript(mapsService);
    $.getScript(driverLoader);
    $.getScript(driverMain);
    $.getScript(driverHelper);
  }
});
