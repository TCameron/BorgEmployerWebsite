<?php
//Emails employee about start anniversary
function mail_emp_start($name, $company, $year, $email){
	echo nl2br("Sending emp start\n\n");
	//send email
	/*$subject = "Happy anniversary, ".$name."!";
	$message = "Congradulations ".$name."! It is your ".$year." year anniversary with ".$company."!";
	mail("$email", "$subject",
	$message, "From: noreply@mjmincentives.com") or die(mysql_error());*/
}

//Emails employee about birthday
function mail_emp_birth($name, $company, $year, $email){
	echo nl2br("Sending emp birth\n\n");
	//send email
	/*$subject = "Happy birthday ".$name."!" ;
	$message = $company." wishes you a happy ".$year." birthday ".$name."!";
	mail("$email", "$subject",
	$message, "From: noreply@mjmincentives.com") or die(mysql_error());*/
}

//Emails manager about employee start anniversary
function mail_man_start($empname, $year, $email){
	echo nl2br("Sending man start\n\n");
	//send email
	/*$subject = $name."'s ".$year."anniversary is tomorrow." ;
	$message = "It is ".$name."'s ".$year." anniversary. Wish them a good one!";
	mail("$email", "$subject",
	$message, "From: noreply@mjmincentives.com") or die(mysql_error());*/
}

//Emails manager about employee birthday
function mail_man_birth($empname, $year, $email){
	echo nl2br("Sending man birth\n\n");
	//send email
	/*$subject = $name."'s ".$year."birthday is tomorrow." ;
	$message = "It is ".$name."'s ".$year." birthday. Wish them a good one!";
	mail("$email", "$subject",
	$message, "From: noreply@mjmincentives.com") or die(mysql_error());*/
}
?>