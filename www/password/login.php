<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Password Recovery</title>
<link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="header"></div>
<div id="page">
	<h2>Login</h2>
    <p>Login to our site's private area.</p>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="fieldGroup"><label for="uname">Username</label><div class="field"><input type="text" name="uname" id="uname" value="" maxlength="20"></div></div>
        <div class="fieldGroup"><label for="pword">Password</label><div class="field"><input type="text" name="pword" id="pword" value="" maxlength="20"></div></div>
        <div class="fieldGroup"><input type="submit" value="Login" style="margin-left: 150px;" /></div>
        <div class="clear"></div>
    </form>
    <a href="forgotPass.php">Forgot your password?</a>
</div>
</body>
</html>
<?php
	ob_flush();
?>