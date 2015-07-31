<?php
include("mail.php");
include("../functional/db.php");

//Instantiate tomorrow's date
$tomorrow = date('m/d',mktime(0,0,0,date('m'), date('d')+1));

//Connect to employees database
$connection = dbConnect("pointemployees");

//Look for matching service dates for today
$check = mysql_query("SELECT * FROM pointemployees WHERE start='$tomorrow'") or die(mysql_error()); 
$verify = mysql_num_rows($check); 

//Check if it is a leap year and send out service date cards
if (date('L')==0){
	if($tomorrow=='02/28'){
		$leapcheck = mysql_query("SELECT * FROM pointemployees WHERE start='02/29'") or die(mysql_error()); 	
		$lverify = mysql_num_rows($leapcheck);
		//Send out service date cards to employees
		if($lverify > 0){
			while($row = mysql_fetch_array($leapcheck)){
				$year = (date('Y')+0) - ($row['syear']+0);
				echo nl2br("Found one for leap service!\n".$row['name']." ".$row['start']." - ".$year." years\n");
				mail_man_start($row['name'], $year, $row['manemail']);
			}
		}
	}
}

//Send out service date cards to managers
if($verify > 0){
	while($row = mysql_fetch_array($check)){
		$year = (date('Y')+0) - ($row['syear']+0);
		echo nl2br("Found one for service!\n".$row['name']." ".$row['start']." - ".$year." years\n");
		mail_man_start($row['name'], $year, $row['manemail']);
	}
}

//Look for matching birth dates for today
$check = mysql_query("SELECT * FROM pointemployees WHERE birth='$tomorrow'") or die(mysql_error());  
$verify = mysql_num_rows($check); 

//Check if it is a leap year and send out birth date cards
if (date('L')==0){
	if($tomorrow=='02/28'){
		$leapcheck = mysql_query("SELECT * FROM pointemployees WHERE start='02/29'") or die(mysql_error()); 	
		$lverify = mysql_num_rows($leapcheck);
		//Send out birth date cards to managers
		if($lverify > 0){
			while($row = mysql_fetch_array($leapcheck)){
				$year = (date('Y')+0) - ($row['byear']+0);
				echo nl2br("Found one for leap birthday!\n".$row['name']." ".$row['birth']." - ".$year." years\n");
				mail_man_birth($row['name'], $year, $row['manemail']);
			}
		}
	}
}

//Send out birth date cards to managers
if($verify > 0){
	while($row = mysql_fetch_array($check)){
		$year = (date('Y')+0) - ($row['byear']+0);
		echo nl2br("Found one for birthday!\n".$row['name']." ".$row['birth']." - ".$year." years\n");
		mail_man_birth($row['name'], $year, $row['manemail']);
	}
}

mysql_close($connection);
?>
