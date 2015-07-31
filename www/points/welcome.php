<?php
include_once("../functional/check.php");
include_once("../functional/db.php");
check_p();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Borg Rewards - Welcome</title>
	<link href="../../css/borgstyles.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<?php
	include("nav.html");
	?>
	<h1>Welcome to the Borg Points Program</h1>
	<?php		
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
			<b>You currently have <?php print $row['points']; ?> points.</b>
			</br>
	<?php
		}
	?>
</body>
</html>