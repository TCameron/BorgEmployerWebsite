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
	<title>Borg Points - Log in or Register</title>  
	<link href="../../css/borgstyles.css" rel="stylesheet" type="text/css" />
</head>
<body> 
	
	<div id="wrapper">

		<!--The log in form-->	
		<div id="login" style="background-color: #ffffff; display:inline">  
			<h3>Log in</h3>  
			<p>Please enter your log in information to access the rewards program.</p>   
			<form method="post" action="" >  
		        <fieldset>  
		            <label for="email">Email:</label><input type="text" name="email" value="" />  </br>
		            <label for="password">Password:</label><input type="password" name="password" value="" />  
		            <input type="submit" name="log" value="Login" />  
		        </fieldset>  
		    </form></br>
			<a href=../../encrypted/forgotPass.php/>Forgot your password?</a>
			<a href="register.php">No account? Click here to register.</a>
		</div>
		
	</div>
	
	<?php
	
	    dbConnect('users'); 
	 
		//Checks the input fields for correct information.
	    if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['log'])){ 
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
				$_COOKIE['pdate'] = $row['pointdate'];
				
				$_SESSION['company'] = $row['company'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['id'] = $row['id'];
				$_SESSION['pdate'] = $row['pointdate'];
				$_SESSION['plevel'] = $row['pointlevel'];
				//$_SESSION['rememberMe'] = $_POST['rememberMe'];
				header('location:welcome.php');
				exit;
			} else {
				print 'Invalid username or password. Please try again.';
			}
		} 
	?> 
</body>  
</html> 