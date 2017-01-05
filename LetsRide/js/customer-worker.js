/**
 * Background thread for customer.
 * Will run script assigned to scriptToRun.
 */

var xhr = new XMLHttpRequest();
var scriptToRun;
var workerTimeout = 2000;

/**
 * Listens to changes on http request.
 */
xhr.onreadystatechange = function () {
  var DONE = 4; // readyState 4 means the request is done.
  var OK = 200; // status 200 is a successful return.
  if (xhr.readyState === DONE) {
    if (xhr.status === OK) {
      console.log(scriptToRun + " :: " + xhr.responseText);
      postMessage(xhr.responseText); // send message to worker
    } else {
      console.log('Error: ' + xhr.status); // An error occurred during the request.
    }
  }
};

/**
 * Listen for messages sent to worker.
 * @param {Event} script to run
 */
self.onmessage = function(e) {
  // set script to run for worker
  if (scriptToRun === undefined) {
    scriptToRun = '../' + e.data;
  }
}

/**
 * Recursively call check within a set time.
 */
function check() {
  if (scriptToRun !== undefined) {
    xhr.open('GET', scriptToRun);
    xhr.send();
  }
  setTimeout(check, workerTimeout);
}

check();