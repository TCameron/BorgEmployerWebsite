<?php
session_start();

include('db.php');
$connection = dbConnect('users');

//Make sure user is logged in to the rewards site.
function check_r(){
	if (!isset($_SESSION['rdate'])) {
		header('location:../rewards/');
		mysql_close($connection);
		exit();
	}
	if($_SESSION['rlevel'] <= 0){
		header('location:../rewards/level.php');
		mysql_close($connection);
		exit();
	}
	$id = $_SESSION['id'];
	$sql = "SELECT * FROM users WHERE '".$_SESSION['rdate']."' > CURDATE() AND id='$id'";
	$check = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($check) <= 0){
		header('location:../rewards/outofdate.php');
		mysql_close($connection);
		exit();
	}
}

//Make sure user is logged in to the points site.
function check_p(){
	if (!isset($_SESSION['pdate'])){
		header('location:../points/');
		mysql_close($connection);
		exit();
	}
	if($_SESSION['plevel'] <= 0){
		header('location:../points/level.php');
		mysql_close($connection);
		exit();
	}
	$id = $_SESSION['id'];
	$sql = "SELECT * FROM users WHERE '".$_SESSION['pdate']."' > CURDATE() AND id='$id'";
	$check = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($check) <= 0){
		header('location:../points/outofdate.php');
		mysql_close($connection);
		exit();
	}
}
?>