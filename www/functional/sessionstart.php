<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Borg Rewards - Logging in...</title>
	</head>
	<body>
		<?php
			//initialize the session
			if (!isset($_SESSION)) {
			  session_start();
			}
			header('location:/welcome.php/');
		?>
	</body>
</html>