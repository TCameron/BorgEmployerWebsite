<?php //unencrypted password example
include("assets/php/database.php"); 
include("assets/php/functions.php");
$show = 'emailForm'; //which form step to show by default
if ($_SESSION['lockout'] == true && (mktime() > $_SESSION['lastTime'] + 900))
{
	$_SESSION['lockout'] = false;
	$_SESSION['badCount'] = 0;
}
if (isset($_POST['subStep']) && $_SESSION['lockout'] != true)
{
	switch($_POST['subStep'])
	{
		case 1:
			//we just submitted an email or username for verification
			$result = checkUNEmail($_POST['uname'],$_POST['email']);
			if ($result['status'] == false )
			{
				$error = true;
				$show = 'userNotFound';
			} else {
				$error = false;
				$show = 'securityForm';
				$securityUser = $result['userID'];
			}
		break;
		case 2:
			//we just submitted the security question for verification
			if ($_POST['userID'] != "" && $_POST['answer'] != "")
			{
				$result = checkSecAnswer($_POST['userID'],$_POST['answer']);
				if ($result == true)
				{
					//answer was right
					$error = false;
					$show = 'successPage';
					$passwordMessage = sendPasswordEmail($_POST['userID']);
					$_SESSION['badCount'] = 0;
				} else {
					//answer was wrong
					$error = true;
					$show = 'securityForm';
					$securityUser = $_POST['userID'];
					$_SESSION['badCount']++;
				}
			} else {
				$error = true;
				$show = 'securityForm';
			}
		break;
	}
}
if ($_SESSION['badCount'] >= 3)
{
	$show = 'speedLimit';
	$_SESSION['lockout'] = true;
	$_SESSION['lastTime'] = '' ? mktime() : $_SESSION['lastTime'];
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Password Recovery</title>
<link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="header"></div>
<div id="page">
	<?php if ($show == 'emailForm') { ?>
	<h2>Password Recovery</h2>
    <p>You can use this form to recover your password if you have forgotten it. Enter either your username or your email address below to get started.</p>
    <?php if ($error == true) { ?><span class="error">You must enter either a username or password to continue.</span><?php } ?>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="fieldGroup"><label for="uname">Username</label><div class="field"><input type="text" name="uname" id="uname" value="" maxlength="20"></div></div>
        <div class="fieldGroup"><label>- OR -</label></div>
        <div class="fieldGroup"><label for="email">Email</label><div class="field"><input type="text" name="email" id="email" value="" maxlength="255"></div></div>
        <input type="hidden" name="subStep" value="1" />
        <div class="fieldGroup"><input type="submit" value="Submit" style="margin-left: 150px;" /></div>
        <div class="clear"></div>
    </form>
    <?php } elseif ($show == 'securityForm') { ?>
    <h2>Password Recovery</h2>
    <p>Please answer the security question below:</p>
    <?php if ($error == true) { ?><span class="error">You must answer the security question correctly to receive your lost password.</span><?php } ?>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="fieldGroup"><label>Question</label><div class="field"><?= getSecurityQuestion($securityUser); ?></div></div>
        <div class="fieldGroup"><label for="answer">Answer</label><div class="field"><input type="text" name="answer" id="answer" value="" maxlength="255"></div></div>
        <input type="hidden" name="subStep" value="2" />
        <input type="hidden" name="userID" value="<?= $securityUser; ?>" />
        <div class="fieldGroup"><input type="submit" value="Submit" style="margin-left: 150px;" /></div>
        <div class="clear"></div>
    </form>
    <?php } elseif ($show == 'userNotFound') { ?>
    <h2>Password Recovery</h2>
    <p>The username or email you entered was not found in our database.</p>
    <?php } elseif ($show == 'successPage') { ?>
    <h2>Password Recovery</h2>
    <p>Your password has been mailed to you. You should receive an email in a few moments with your password in it. <strong>(Mail will not send unless you have an smtp server running locally.)</strong><br /><br /><a href="login.php">Return</a> to the login page. </p>
    <p>This is the message that would appear in the email:</p>
    <div class="message"><?= $passwordMessage;?></div>
    <?php } elseif ($show == 'speedLimit') { ?>
    <h2>Warning</h2>
    <p>You have answered the security question wrong too many times. You will be locked out for 15 minutes, after which you can try again.</p><br /><br /><a href="login.php">Return</a> to the login page. </p>
    <?php } ?>
</div>
</body>
</html>
<?php
	ob_flush();
	$mySQL->close();
?>