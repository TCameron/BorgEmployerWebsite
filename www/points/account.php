<?php
include_once("../functional/check.php"); 
include_once("../functional/db.php");
include_once("../functional/makesafe.php"); 
include_once("../functional/emailcheck.php");
check_p();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Borg Points - Edit account</title>
	<link href="../../css/borgstyles.css" rel="stylesheet" type="text/css" />
</head>
<body>
			
	<?php
		include("nav.html");
		
		//To get the current end date and points total.
		
		//Connect to MySQL database.
		$connection = dbConnect('users');
		$id = $_SESSION['id'];
		$sql = "SELECT * FROM users WHERE id='$id' LIMIT 1";
		$check = mysql_die($sql,''); 
		$verify = mysql_num_rows($check);  
  
		if($verify > 0){ 
			$row = mysql_fetch_array($check);
	?>
			<b>Your subscription will run out on <?php print $row['pointdate']; ?>. </b>
			</br>
			<b>You have <?php print $row['points']; ?> left.</b>
	<?php
		}
	?>
	

	<!--Input boxes-->
    <form method="post" action="" >
        <fieldset>
            <label for="password">Password:</label><input type="password" name="password" class="input" value="" /> </br>
			<label for="confirm">Confirm&nbsp;Password:</label><input type="password" name="confirm" class="input" value="" /> </br>
            <input type="submit" name="save" value="Save" />  
        </fieldset> 
    </form></br>
	
	<?php
	
		//Only mess with the database if Save is hit.
		if(isset($_POST['save'])){
				
			//Make sure password and confirm pass fields are identical
			if($_POST['password']==$_POST['confirm']){
							
				//Get the HTML form information.
				$id = $_SESSION['id'];
				$pass = make_safe($_POST['password']);
				$confirm = make_safe($_POST['confirm']);
					
				//Check if the ID exists
				$sql = "SELECT * FROM users WHERE id='$id' LIMIT 1";
				$check = mysql_die($sql,''); 
				$verify = mysql_num_rows($check);  
  
				if($verify > 0){
					   
					//Edit the current user info in the database.
					$update = "UPDATE users SET password='".md5($pass)."' 
						WHERE id='$id'";
					mysql_die($update,'');
					
					mysql_close($connection);
					
				} else {
					
					echo 'There is no user listed under that id.';
					mysql_close($connection);
					
				}
			} else {
				
				echo 'Confirm does not match password';
				
			}
		}
	?>
	
</body>		
</html>