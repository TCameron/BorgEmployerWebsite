<?php
include("../functional/db.php"); 
include("../functional/makesafe.php"); 
?>

<html>
<body>
<label for="payer_email">email:</label><input type="text" name="payer_email" value="" />
<input type="submit" name="register" value="Register" /> 

<?php  
  
$connection = dbConnect('users');

// read the post from PayPal system and add 'cmd'  
$req = 'cmd=_notify-validate';  
foreach ($_POST as $key => $value) {  
$value = urlencode(stripslashes($value));  
$req .= "&$key=$value";  
}  
// post back to PayPal system to validate  
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";  
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";  
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";  
  
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);  
  
if (!$fp) {  
// HTTP ERROR  
} else {  
fputs ($fp, $header . $req);  
while (!feof($fp)) {  
$res = fgets ($fp, 1024);  
if (strcmp ($res, "VERIFIED") == 0) {  

// PAYMENT VALIDATED & VERIFIED!  

if(isset($_POST["register"])){
$email = make_safe($_POST['payer_email']);  
$password = mt_rand(1000, 9999);  
$id = mysql_query("SELECT id FROM users ORDER BY id DESC LIMIT 1") or die(mysql_error());
$id++;  
  
mysql_query("INSERT INTO users (email, password) VALUES('". $email ."', '".md5($password)."' ) ") or die(mysql_error());  
  
$to      = $email;  
$subject = 'Borg Rewards Login Credentials';  
$message = ' 

Thank you for your subscription!

Your subscription will be active for 1 year. 
 
Your account information 
------------------------- 
Email: '.$email.' 
Password: '.$password.' 
------------------------- 
 
You can now login at mjmincentives.com/login.php
It is highly suggested that you change your password immediately.';

$headers = 'From:noreply@mjmincentives.com' . "\r\n";  
  
mail($to, $subject, $message, $headers);  
?>
<style type="text/javascript">
	print("Successfully registered");
</style>
<?php
}  
  
else if (strcmp ($res, "INVALID") == 0) {  
  
// PAYMENT INVALID & INVESTIGATE MANUALY!  
 
$to      = 'invalid@mjmincentives.com';  
$subject = 'Borg Rewards Invalid Payment';  
$message = ' 
 
Dear Administrator, 
 
A payment has been made but is flagged as INVALID. 
Please verify the payment manually and contact the buyer. 
 
Buyer Email: '.$email.' 
';  
$headers = 'From:noreply@mjmincentives.com' . "\r\n";  
  
mail($to, $subject, $message, $headers);
}
}
fclose ($fp);
}
}
mysql_close($connection);
?>  
</body>
</html>