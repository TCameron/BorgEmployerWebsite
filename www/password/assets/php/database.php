<?php
session_start();
ob_start();
$hasDB = false;
$server = 'localhost';
$user = 'root';
$pass = 'mysql';
$db = 'passwordrecovery';
$mySQL = new mysqli($server,$user,$pass,$db);
if ($mySQL->connect_error)
{
    die('Connect Error (' . $mySQL->connect_errno . ') '. $mySQL->connect_error);
}
?>