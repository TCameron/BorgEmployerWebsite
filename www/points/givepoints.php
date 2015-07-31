<?php
include_once("../functional/check.php"); 
include_once("../functional/db.php");
include_once("../functional/makesafe.php");
check_p();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Borg Points - Edit employees</title>
	<link href="../../css/borgstyles.css" rel="stylesheet" type="text/css" />
</head>
<body>
	
	<?php
	include("nav.html");
	?>
	
	<!--Create the forms. In order for the employee to be edited
	the name field must match the employee that exists in the db-->
    <form method="post" action="" >  
        <fieldset>
			<label for="name">Name:</label>
			
			<!--Used for populating the list of employees that are registered under the currently logged in manager-->
			<?php
				
				$connection = dbConnect('pointemployees');
				$id = $_SESSION['id'];
				
				$sql = "SELECT * FROM pointemployees WHERE id='$id' ORDER BY name";
				$result = mysql_die($sql, '');
				$verify = mysql_num_rows($result);  
			
				if($verify > 0){
					
					//Creates the table of employees for the ID of the currently logged in user.
					?>
					<select name="name">
						<option value="Select name">-- Select Employee --</option>
						<?php 
						while ($row = mysql_fetch_array($result)) {
						?>
							<option value="<?php print $row['name']; ?>"><?php print $row['name']; ?></option>							
						<?php } ?>
					</select>
				<?php	
				} else {
					
					echo "No employees found for you</br>";
				
				}
				
				mysql_close($connection);
			?>
			</br>
			
			
            <label for="points">Give&nbsp;Points:</label>
		    	<select name="points">
		    		<option value="Select points">-- Select Amount --</option>
					<option value="20">Thank You - 20 points</option>
					<option value="40">Pat on the Back - 40 points</option>
					<option value="100">Applaud - 100 points</option>
					<option value="250">Bronze Medal - 250 points</option>
					<option value="500">Silver Medal - 500 points</option>
					<option value="1000">Gold Medal - 1000 points</option>
				</select></br>
            <input type="submit" name="save" value="Save">  
        </fieldset> 
    </form></br>
	

	
	<?php
	
		//Only mess with the database if Save is hit.
		if(isset($_POST["save"])){
		
			//Connect to MySQL database.
			$connection = dbConnect('pointemployees');
		
			//Get the HTML form information.
			$name = make_safe($_POST['name']);
			$points = make_safe($_POST['points']);
			
			$sql = "SELECT * FROM pointemployees WHERE name='$name' LIMIT 1";
			
			$check = mysql_die($sql,'');  
			$verify = mysql_num_rows($check);  
  
			if($verify > 0){   
				
				if($_SESSION['points'] >= $points){
					
					$row = mysql_fetch_array($check);
					$newpoints = $points + $row['points'];
					$id = $_SESSION['id'];
					$update = "UPDATE pointemployees SET points = '$newpoints' WHERE name='$name'";
					
					//Insert the new amount of points into the database.
					mysql_die($update, '');
				
					mysql_close($connection);
					
					//Change amount of points in the user's database.
					$uconnection = dbConnect('users');
					$_SESSION['points'] -= $points;
					$userupdate = "UPDATE users SET points = '".$_SESSION['points']."' WHERE id = '$id'";
					mysql_die($userupdate,'');
					
					mysql_close($uconnection);
					
				} else {
					
					echo 'You do not have enough points in your account!';
			
				}
			
			} else {
				
				echo 'There is no employee listed under that name.';
				mysql_close($connection);
				
			}
		}
	?>

</body>
</html>