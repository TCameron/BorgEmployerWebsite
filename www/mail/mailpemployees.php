<?php
include("mail.php");
include("../functional/db.php");

//Instantiate today's date
$today = date('m/d',mktime(0,0,0,date('m'), date('d')));

//Connect to employees database
$connection = dbConnect("pointemployees");

//Look for matching service dates for today
$check = mysql_query("SELECT * FROM pointemployees WHERE start='$today'") or die(mysql_error());  
$verify = mysql_num_rows($check); 

//Check if it is a leap year and send out birth date cards
if (date('L')==0){
	if($today=='02/28'){
		$leapcheck = mysql_query("SELECT * FROM pointemployees WHERE start='02/29'") or die(mysql_error()); 	
		$lverify = mysql_num_rows($leapcheck);
		//Send out service date cards to employees
		if($lverify > 0){
			while($row = mysql_fetch_array($leapcheck)){
				$year = (date('Y')+0) - ($row['syear']+0);
				echo nl2br("Found one for leap service!\n".$row['name']." ".$row['start']." - ".$year." years\n");
				mail_emp_start($row['name'], $row['company'], $year, $row['email']);
			}
		}
	}
}

//Send out service date cards to employees
if($verify > 0){
	while($row = mysql_fetch_assoc($check)){
		$year = (date('Y')+0) - ($row['syear']+0);
		echo nl2br("Found one for service!\n".$row['name']." ".$row['start']." - ".$year." years\n");
		mail_emp_start($row['name'], $row['company'], $year, $row['email']);
	}
}

//Look for matching birth dates for today
$check = mysql_query("SELECT * FROM pointemployees WHERE birth='$today'") or die(mysql_error());  
$verify = mysql_num_rows($check); 

//Check if it is a leap year and send out birth date cards
if (date('L')==0){
	if($today=='02/28'){
		$leapcheck = mysql_query("SELECT * FROM pointemployees WHERE start='02/29'") or die(mysql_error()); 	
		$lverify = mysql_num_rows($leapcheck);
		//Send out service date cards to employees
		if($lverify > 0){
			while($row = mysql_fetch_array($leapcheck)){
				$year = (date('Y')+0) - ($row['byear']+0);
				echo nl2br("Found one for leap birthday!\n".$row['name']." ".$row['birth']." - ".$year." years\n");
				mail_emp_birth($row['name'], $row['company'], $year, $row['email']);
			}
		}
	}
}

//Send out birth date cards to employees
if($verify > 0){
	while($row = mysql_fetch_array($check)){
		$year = (date('Y')+0) - ($row['byear']+0);
		echo nl2br("Found one for birthday!\n".$row['name']." ".$row['birth']." - ".$year." years\n");
		mail_emp_birth($row['name'], $row['company'], $year, $row['email']);
	}
}

mysql_close($connection);
?>
