<?php
include_once("../functional/db.php");
include_once("../functional/makesafe.php");
include_once("../functional/emailcheck.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
	<head>  
		<title>Borg Points - Log in or Register</title>  
		<link href="../../css/borgstyles.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	  	<!--The register form-->
	  	<div id="reg" style="float: left; background-color: #ffffff; display:inline">
			<h3>Register</h3>
			<p>Please enter your information to register for the program.</p>
			<form method="post" action="" >
				<fieldset>
					<label for="name">Name:</label><input type="text" name="name" class="input" value="" /> </br>
					<label for="remail">Email:</label><input type="text" name="remail" class="input" value="" /> </br>
					<label for="rpassword">Password:</label><input type="password" name="rpassword" class="input" value="" /> </br>
					<label for="confirm">Confirm&nbsp;Password:</label><input type="password" name="confirm" class="input" value="" /> </br>
					<label for="company">Company:</label><input type="text" name="company" class="input" value="" /> </br>	
					<input type="submit" name="register" value="Register" />				
				</fieldset>
			</form></br>
	  	</div>
	<?php		
		//Checks the input fields for correct information.
	    if(isset($_POST['name']) && isset($_POST['remail']) && isset($_POST['rpassword']) && isset($_POST['company']) && isset($_POST['register']) && $_POST['rpassword'] == $_POST['confirm']){
	    	if(validEmail($_POST['remail'])){				
	    		$email = make_safe($_POST['remail']);
	    		if($verify = 0){
			    	$name = make_safe($_POST['name']); 
					$password = make_safe(md5($_POST['rpassword']));
					$company = make_safe($_POST['company']);
					$id = mysql_query("SELECT id FROM users ORDER BY id DESC LIMIT 1") or die(mysql_error());
					$id++; 
					$sql = "INSERT INTO users (id, name, password, email, company, pointdate, pointlevel, rewarddate, rewardlevel, points)
							VALUES ('$id', '$name', '$password, '$email', '$company', CURDATE(), 0, CURDATE(), 0, 0)";
							
					mysql_die($sql,'');  
					
					//If there is a result, log in and go to Welcome page.
					header('location:completeregister.php');
					exit;
				} else {
					echo 'Email address is already in the system. Please register with another.';
				}
			} else {
				echo 'Please enter a valid email address.';
			}
		} elseif(isset($_POST['register']) && (!isset($_POST['name']) || !isset($_POST['remail']) || !isset($_POST['rpassword']) || !isset($_POST['company']))){
			echo 'Please fill out every field.';
		}
	?>
	
		<!--Paypal registration-->
		<div id="register" style="float: left; background-color: #ffffff; display:inline">   
		    <br /> 
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
					">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form> 
		</div>
	</body>
</html>