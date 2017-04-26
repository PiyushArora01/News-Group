<?php
	include "dbconn.php";
	$page = "login";

	if ( isset($_POST['username']) ){
		$username = stripslashes($_POST['username']);
		$username = $link->real_escape_string($username);
		$password = stripslashes($_POST['password']);
		$password = $link->real_escape_string($password);
		$oath = stripslashes($_POST['password']);
		$oath = $link->real_escape_string($oath);    
		$query = "SELECT * FROM `user` WHERE `username`='$username' and `password`='$password' and `oath_provider` = ''";
		$result = $link->query($query) or die($link->error());
		$rows = $result->num_rows;
		if($rows == 1){
			$_SESSION['username'] = $username;
			header("Location: index.php");
			exit();
		} else {
			$_SESSION['MESSAGE'] = "Invalid Username or Password!";
			$_SESSION['MESSAGE_TYPE'] = "alert-danger";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php include("header.html"); ?>
<link rel="stylesheet" href="css/login.css">
<title>News Group</title>
</head>

<body>


<script>
	// This is called with the results from from FB.getLoginStatus().
	function statusChangeCallback(response) {
	console.log('statusChangeCallback');
	console.log(response);
	// The response object is returned with a status field that lets the
	// app know the current login status of the person.
	// Full docs on the response object can be found in the documentation
	// for FB.getLoginStatus().
	if (response.status === 'connected') {
		// Logged into your app and Facebook.
		testAPI();
	} else {
		// The person is not logged into your app or we are unable to tell.
		document.getElementById('status').innerHTML = 'Please log ' +
		'into this app.';
	}
	}

	// This function is called when someone finishes with the Login
	// Button.  See the onlogin handler attached to it in the sample
	// code below.
	function checkLoginState() {
	FB.getLoginStatus(function (response) {
		statusChangeCallback(response);
	});
	}

	window.fbAsyncInit = function () {
	FB.init({
		appId: '1774685882846303',
		cookie: true,  // enable cookies to allow the server to access 
		// the session
		xfbml: true,  // parse social plugins on this page
		version: 'v2.9' // use graph api version 2.8
	});

	// Now that we've initialized the JavaScript SDK, we call 
	// FB.getLoginStatus().  This function gets the state of the
	// person visiting this page and can return one of three states to
	// the callback you provide.  They can be:
	//
	// 1. Logged into your app ('connected')
	// 2. Logged into Facebook, but not your app ('not_authorized')
	// 3. Not logged into Facebook and can't tell if they are logged into
	//    your app or not.
	//
	// These three cases are handled in the callback function.

	FB.getLoginStatus(function (response) {
		statusChangeCallback(response);
	});

	};

	// Load the SDK asynchronously
	(function (d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	// Here we run a very simple test of the Graph API after login is
	// successful.  See statusChangeCallback() for when this call is made.
	function testAPI() {
	console.log('Welcome!  Fetching your information.... ');
	FB.api('/me', function (response) {
		console.log('Successful login for: ' + response.name);
		document.getElementById('status').innerHTML =
		'Thanks for logging in, ' + response.name + '!';

	});
	}

</script>

<?php include("navbar.php"); ?>


<div class="wrapper">
	<div class="container form-signin">
	<?php include("message.php"); ?>
	<form method="post" action="login.php">
		<h2 class="form-signin-heading">Sign In</h2>

		<label for="id_username" class="sr-only">Username</label>
		<input type="text" name="username" id="id_username" class="form-control" maxlength="254" placeholder="Username" required
		autofocus>

		<label for="id_password" class="sr-only">Password</label>
		<input type="password" name="password" id="id_password" class="form-control" placeholder="Password" required>
		<div align="right"><a href="register.php">New user? Register here!</a></div>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
		<center>
		<div style="font-size:16px; margin: 10px">or</div>
		<div scope="public_profile,email" onlogin="checkLoginState();" class="fb-login-button btn-block" data-width="300" data-max-rows="1"
			data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>
		<div id="status"></div>
		</center>
	</form>

	</div>
</div>
<?php include("scripts.html"); ?>
</body>

</html>