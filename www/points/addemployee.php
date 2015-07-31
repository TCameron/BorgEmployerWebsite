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
	<title>Borg Points - Add employees</title>
	<link href="../../css/borgstyles.css" rel="stylesheet" type="text/css" />
</head>
<body>
	
	<?php
	include("nav.html");
	
	$level = $_SESSION['level'];
	if($level == 1){
		$max = 5;
	} elseif($level == 2){
		$max = 20;
	} elseif($level == 3){
		$max = 100;	
	}
	
	//Connect to MySQL database.
	$connection = dbConnect('pointemployees');
	$id = $_SESSION['id'];
		
	$sql = "SELECT name FROM pointemployees WHERE id='$id'";
	$result = mysql_die($sql, '');
	$count = mysql_num_rows($result);
	$dif = $max - $count;
	?>
		
	For Start and Birth dates, use MM/DD/YYYY format.</br>
	You may add <?php echo $dif; ?> more employees.
	
	<!--Input boxes used for adding an employee.-->
    <form method="post" action="" >  
        <fieldset>  
			<label for="name">Name:</label><input type="text" name="name" class="input" value="" /> </br>
            <label for="email">Email:</label><input type="text" name="email" class="input" value="" /> </br>
			<label for="start">Start&nbsp;Date:</label><input type="text" name="start" class="input" value="" /> </br>
            <label for="birth">Birth&nbsp;Date:</label><input type="text" name="birth" class="input" value="" /> </br>
            <input type="submit" name="save" value="Save">  
        </fieldset> 
    </form></br>
	
	<?php
		//Only mess with the database if Save is hit.
		if(isset($_POST["save"])&& $dif > 0){
		
			//Connect to MySQL database.
			$connection = dbConnect('pointemployees');
		
			//Get the HTML form information.
			$name = make_safe($_POST['name']);
			$email = make_safe($_POST['email']); 
			list($smonth, $sday, $syear) = explode("/",make_safe($_POST['start']));
			list($bmonth, $bday, $byear) = explode("/",make_safe($_POST['birth']));
			
			if(checkdate($smonth,$sday,$syear)){
  				if(checkdate($bmonth,$bday,$byear)){ 
					$start = $smonth ."/". $sday;
					$birth = $bmonth ."/". $sday;
					//Insert a new employee into the database.
					$sql = "INSERT INTO pointemployees (name, email, company, start, syear, birth, byear, id, manemail)
					VALUES ('$name', '$email', '".$_SESSION['company']."', '$start', '$syear', '$birth', '$byear', '".$_SESSION['id']."', '".$_SESSION['email']."')";
					mysql_die($sql,''); 
				} else {
					echo 'The entered birth date is invalid. Please enter a valid date.';
				}
			} else {
				echo 'The entered start date is invalid. Please enter a valid date.';
			}
			
			
			mysql_close($connection);
			
			$dif -= 1;
			
		} elseif(isset($_POST["save"]) && $dif <= 0){
			echo 'You do not have any more room for employees.</br>
			Either upgrade your account to more slots or remove one to add.';
		}
	?>
	
</body>
</html>