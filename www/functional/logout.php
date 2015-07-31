<?php
session_start();
if(isset($_SESSION['rdate'])){
	session_destroy();
	header('location:../../rewards/');
}else if(isset($_SESSION['pdate'])){
	session_destroy();
	header('location:../../points/');
}else{
	session_destroy();
	header('location:../');
}
?>