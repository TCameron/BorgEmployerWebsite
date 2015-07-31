<?php
include_once("../functional/db.php");
include_once("../functional/makesafe.php");

//Handles SESSION security.
$timeout = 3 * 60; // 3 minutes
$fingerprint = md5('SECRET-SALT'.$_SERVER['HTTP_USER_AGENT']);
session_start();
if ( (isset($_SESSION['last_active']) && (time() > ($_SESSION['last_active']+$timeout)))
     || (isset($_SESSION['fingerprint']) && $_SESSION['fingerprint']!=$fingerprint)
     || isset($_GET['logout']) ) {
    session_destroy();
}
session_regenerate_id(); 
$_SESSION['last_active'] = time();
$_SESSION['fingerprint'] = $fingerprint;

session_name('tzLogin');

// Making the cookie live for 2 weeks
setcookie(session_name(), session_id(), time()+2*7*24*60*60, "/");

/*
	//For cookie memorization
	if($_SESSION['id'] && !isset($_COOKIE['tzRemember']) && !$_SESSION['rememberMe'])
{
	// If you are logged in, but you don't have the tzRemember cookie (browser restart)
	// and you have not checked the rememberMe checkbox:

	$_SESSION = array();
	session_destroy();
	
	// Destroy the session
}*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
	<title>Borg Rewards - Log in or Register</title>  
	<link href="../../css/borgstyles.css" rel="stylesheet" type="text/css" />
</head>
<body> 
	
	<?php
       
	    dbConnect('users'); 
	 
		//Checks the input fields for correct information.
	    if(isset($_POST['email']) && isset($_POST['password'])){ 
			$email = make_safe($_POST['email']);
			$password = make_safe(md5($_POST['password']));
			$sql = "SELECT * FROM users WHERE email='$email' and password='$password' LIMIT 1";
			$check = mysql_die($sql,'');  
			$verify = mysql_num_rows($check);  
			
			//If there is a result, log in and go to Welcome page.
			if($verify > 0){
				$row = mysql_fetch_array($check);
				$_COOKIE['company'] = $row['company'];
				$_COOKIE['email'] = $row['email'];
				$_COOKIE['id'] = $row['id'];
				$_COOKIE['rdate'] = $row['rewarddate'];
				
				
				$_SESSION['company'] = $row['company'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['id'] = $row['id'];
				$_SESSION['rdate'] = $row['rewarddate'];
				$_SESSION['rlevel'] = $row['rewardlevel'];
				//$_SESSION['rememberMe'] = $_POST['rememberMe'];
				header('location:welcome.php');
				exit;
			} else {
				print 'Invalid username or password. Please try again.';
			}
		} 
	?> 

	<div id="wrapper">
	  
		<!--Paypal registration-->
		<div id="register" style="float: left; background-color: #ffffff; display:inline">  
		    <h3>Register</h3>  
		    <p>It costs $15.00 per year for access. Use the link below to pay.<br /> 
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
					">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form> 
		</div>  
		
		<!--The log in form-->	
		<div id="login" style="float: right; background-color: #ffffff; display:inline">  
			<h3>Log in</h3>  
			<p>Please enter your log in information to access the rewards program</p>   
			<form method="post" action="" >  
		        <fieldset>  
		            <label for="email">Email:</label><input type="text" name="email" value="" />  </br>
		            <label for="password">Password:</label><input type="password" name="password" value="" />  
		            <input type="submit" value="Login" />  
		        </fieldset>  
		    </form></br>
			<!--<a href=../../encrypted/forgotPass.php/>Forgot your password?</a>-->
		</div>
		
	</div>

</body>  
</html> 