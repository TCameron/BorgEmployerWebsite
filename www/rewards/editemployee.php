<?php
include_once("../functional/check.php"); 
include_once("../functional/db.php");
include_once("../functional/makesafe.php");
check_r();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Borg Rewards - Edit employees</title>
	<link href="../../css/borgstyles.css" rel="stylesheet" type="text/css" />
</head>
<body>
	
	<?php
	include("nav.html");
	?>
	
	<!--Create the forms. In order for the employee to be edited
	the name field must match the employee that exists in the db-->
	For Start and Birth dates, use the MM/DD/YYYY format.
    <form method="post" action="" >  
        <fieldset>
			<label for="name">Name:</label>
			<!--Used for populating the list of employees that are registered under the currently logged in manager-->
			<?php
				
				$connection = dbConnect('rewardemployees');
				$id = $_SESSION['id'];
				
				$sql = "SELECT * FROM rewardemployees WHERE id='$id' ORDER BY name";
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
							<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>							
						<?php } ?>
					</select>
				<?php	
				} else {
					
					echo "No employees found for you</br>";
				
				}
				
				mysql_close($connection);
			?>
			</br>
            <label for="email">Email:</label><input type="text" name="email" class="input" value="" /> </br>
			<label for="start">Start&nbsp;Date:</label><input type="text" name="start" class="input" value="" /> </br>
            <label for="birth">Birth&nbsp;Date:</label><input type="text" name="birth" class="input" value="" /> </br>
            <input type="submit" name="save" value="Save">
            <input type="submit" name="delete" value="Delete">
        </fieldset> 
    </form></br>
	
	<?php
		$id = $_SESSION['id'];
		
		//Only mess with the database if Save is hit.
		if(isset($_POST["save"])){
		
			//Connect to MySQL database.
			$connection = dbConnect('rewardemployees');
		
			//Get the HTML form information.
			$name = make_safe($_POST['name']);
			$email = make_safe($_POST['email']); 
			list($smonth, $sday, $syear) = explode("/",make_safe($_POST['start']));
			list($bmonth, $bday, $byear) = explode("/",make_safe($_POST['birth']));
			
			$sql = "SELECT * FROM rewardemployees WHERE name='$name' LIMIT 1";
			
			$check = mysql_die($sql,'');  
			$verify = mysql_num_rows($check);  
  			if(checkdate($smonth,$sday,$syear)){
  				if(checkdate($bmonth,$bday,$byear)){
					if($verify > 0){   
						$start = $smonth ."/". $sday;
						$birth = $bmonth ."/". $sday;
						
						$update = "UPDATE rewardemployees SET email='$email', start='$start', syear='$syear', birth='$birth', byear='$byear'
						WHERE name='$name' AND id='$id'";
						
						echo $update;
						
						//Update the employee's entry.
						mysql_die($update, '');
					
					} else {
						
						echo 'There is no employee listed under that name.';
						
					}
				} else {
					echo 'The entered birth date is invalid. Please enter a valid date.';
				}
			} else {
				echo 'The entered start date is invalid. Please enter a valid date.';
			}
			mysql_close($connection);
		}
		
		if(isset($_POST["delete"])){
		
			//Connect to MySQL database.
			$connection = dbConnect('rewardemployees');
		
			//Get the HTML form information.
			$name = make_safe($_POST['name']);

			$sql = "SELECT * FROM rewardemployees WHERE name='$name' LIMIT 1";
			
			$check = mysql_die($sql,'');  
			$verify = mysql_num_rows($check);  
  
			if($verify > 0){   
				
				$delete = "DELETE FROM rewardemployees WHERE name='$name' AND id='$id' LIMIT 1";
				
				//Delete the employee from the database.
				mysql_die($delete, '');
				
				?>
					<select name="name">
						<option value="Select name">-- Select Employee --</option>
						<?php 
						while ($row = mysql_fetch_array($result)) {
						?>
							<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>							
						<?php } ?>
					</select>
					
				<?php
			
			} else {
				
				echo 'There is no employee listed under that name.';
				
			}				
			mysql_close($connection);
		}
	?>

</body>
</html>