<?php // db.php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'MyNewPass';

function dbConnect($db='') {
    global $dbhost, $dbuser, $dbpass;
    
    $dbcnx = @mysql_connect($dbhost, $dbuser, $dbpass)
        or die('The site database appears to be down.');

    if ($db!='' and !@mysql_select_db($db))
        die('The site database is unavailable.');
    
    return $dbcnx;
}

function mysql_die($sql, $err){
	if($err=''){
		$err = mysql_error();
	}
	$check = mysql_query($sql) or die($err);
	return $check;
}
?>
