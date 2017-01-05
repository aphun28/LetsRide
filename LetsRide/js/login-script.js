/**
 * Homepage Scripts
 */

/**
 * Login form for Driver.
 */
$("form[name='driverLogin']").on("submit", function(e) {
  e.preventDefault();
  // retrieve input values
  var user = $("input[name='driverUser']").val();
  var pass =  $("input[name='driverPass']").val();
  // send form info to process
  $.ajax({
    type: 'post',
    url: 'php/loginDriver.php',
    data: {user: user, pass: pass},
    success: function(data) {
      if (data > 0) { // login successful
        window.location.href = "driver.php"
      }
      else if (data < 0) { // login failed
        alert('Incorrect Username or Password');
      }
      else { // error
        alert(data);
      }
    }
  });
});

/**
 * Login form for Rider.
 */
$("form[name='riderLogin']").on("submit", function(e) {
  e.preventDefault();
  // retrieve input values
  var user = $("input[name='riderUser']").val();
  var pass =  $("input[name='riderPass']").val();
  // send form info to process
  $.ajax({
    type: 'post',
    url: 'php/loginRider.php',
    data: {user: user, pass: pass},
    success: function(data) {
      if (data > 0) { // login successful
        window.location.href = "rider.php"
      }
      else if (data < 0) { // login failed
        alert('Incorrect Username or Password');
      }
      else { // error
        alert(data);
      }
    }
  });
});
