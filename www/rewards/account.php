<?php
include_once("../functional/check.php"); 
include_once("../functional/db.php");
include_once("../functional/makesafe.php");
check_r();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Borg Rewards - Edit account</title>
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
			<b>Your subscription will run out on <?php print $row['rewarddate']; ?>. </b>
			</br>
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
				
				//Connect to MySQL database.
				$connection = dbConnect('users');
			
				//Get the HTML form information.
				$id = $_SESSION['id'];
				$pass = make_safe($_POST['password']);
				$confirm = make_safe($_POST['confirm']);
				  
				//Choose the current user
				$check = mysql_query("SELECT * FROM users WHERE id = '$id' LIMIT 1") or die(mysql_error());  

				//Update the current manager in the database
				mysql_query("UPDATE users SET password='".md5($password)."' 
					WHERE id = '$id' ") or die(mysql_error()); 
				
				mysql_close($connection);
				
			}else{
				
				echo 'Confirm does not match password';
			
			}
		}
	?>
</body>		
</html>