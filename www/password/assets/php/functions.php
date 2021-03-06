<?php

function checkUNEmail($uname,$email)
{
	global $mySQL;
	$userID = 'X';
	$error = array('status'=>false,'userID'=>0);
	if (isset($email) && trim($email) != '') {
		//email was entered
		if ($SQL = $mySQL->prepare("SELECT `ID` FROM `users` WHERE `Email` = ? LIMIT 1"))
		{
			$SQL->bind_param('s',trim($email));
			$SQL->execute();
			$SQL->store_result();
			$numRows = $SQL->num_rows();
			$SQL->bind_result($userID);
			$SQL->fetch();
			$SQL->close();
			if ($numRows >= 1) return array('status'=>true,'userID'=>$userID);
		} else { return $error; }
	} elseif (isset($uname) && trim($uname) != '') {
		//username was entered
		if ($SQL = $mySQL->prepare("SELECT `ID` FROM users WHERE Username = ? LIMIT 1"))
		{
			$SQL->bind_param('s',trim($uname));
			$SQL->execute();
			$SQL->store_result();
			$numRows = $SQL->num_rows();
			$SQL->bind_result($userID);
			$SQL->fetch();
			$SQL->close();
			if ($numRows >= 1) return array('status'=>true,'userID'=>$userID);
		} else { return $error; }
	} else {
		//nothing was entered;
		return $error;
	}
}

function getSecurityQuestion($userID)
{
	global $mySQL;
	$questions = array();
	$questions[0] = "What is your mother's maiden name?";
	$questions[1] = "What city were you born in?";
	$questions[2] = "What is your favorite color?";
	$questions[3] = "What year did you graduate from High School?";
	$questions[4] = "What was the name of your first boyfriend/girlfriend?";
	$questions[5] = "What is your favorite model of car?";
	if ($SQL = $mySQL->prepare("SELECT `secQ` FROM `users` WHERE `ID` = ? LIMIT 1"))
	{
		$SQL->bind_param('i',$userID);
		$SQL->execute();
		$SQL->store_result();
		$SQL->bind_result($secQ);
		$SQL->fetch();
		$SQL->close();
		return $questions[$secQ];
	} else {
		return false;
	}
}

function checkSecAnswer($userID,$answer)
{
	global $mySQL;
	if ($SQL = $mySQL->prepare("SELECT `Username` FROM `users` WHERE `ID` = ? AND LOWER(`secA`) = ? LIMIT 1"))
	{
		$answer = strtolower($answer);
		$SQL->bind_param('is',$userID,$answer);
		$SQL->execute();
		$SQL->store_result();
		$numRows = $SQL->num_rows();
		$SQL->close();
		if ($numRows >= 1) { return true; }
	} else {
		return false;
	}
}

function sendPasswordEmail($userID)
{
	global $mySQL;
	if ($SQL = $mySQL->prepare("SELECT `Username`,`Email`,`Password` FROM `users` WHERE `ID` = ? LIMIT 1"))
	{
		$SQL->bind_param('i',$userID);
		$SQL->execute();
		$SQL->store_result();
		$SQL->bind_result($uname,$email,$password);
		$SQL->fetch();
		$SQL->close();
		$message = "Dear $uname,\r\n";
		$message .= "Here is your requested lost password for your account at our site:\r\n";
		$message .= "-----------------------\r\n";
		$message .= "$password\r\n";
		$message .= "-----------------------\r\n";
		$message .= "Our login page: <a href=\"login.php\">http://www.oursite.com/login.php</a>\r\n\r\n";
		$message .= "Thanks,\r\n";
		$message .= "-- Our site team";
		$headers .= "From: Our Site <webmaster@oursite.com> \n";
		$headers .= "To-Sender: \n";
		$headers .= "X-Mailer: PHP\n"; // mailer
		$headers .= "Reply-To: webmaster@oursite.com\n"; // Reply address
		$headers .= "Return-Path: webmaster@oursite.com\n"; //Return Path for errors
		$headers .= "Content-Type: text/html; charset=iso-8859-1"; //Enc-type
		$subject = "Your Lost Password";
		@mail($email,$subject,$message,$headers);
		return str_replace("\r\n","<br/ >",$message);
	}
}

?>