<?php
include_once("../functional/check.php"); 
include_once("../functional/db.php");
check_p();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>
			Borg Points - Buy Points
		</title>
	<link href="../../css/borgstyles.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8"/>
	<link href="../../css/style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8"/>
	</head>
	<body>
		
		<?php
		include("nav.html");
		?>
		
		<!--Paypal Button-->
		<form name="_xclick" action="https://www.paypal.com/us/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="business" value="shadosneko@gmail.com">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="item_name" value="Borg Points">
			
			<!--Drop down menu for point selection.-->
			<table>
				<tr>
			    	<td>
			    		<input type="hidden" name="on0" value="Points">Points</td>
			    		
			    	<!--The drop down box for choosing point amounts.-->
			    	<td>
				    	<select name="os0">
				    		<option value="Select points">-- Select Amount --</option>
							<option value="50">50 Points - $5</option>
							<option value="100">100 Points - $10</option>
							<option value="250">250 Points - $25</option>
							<option value="500">500 Points - $50</option>
							<option value="1000">1000 Points - $100</option>
						</select>
					</td>
					
					<!--Specify the price that PayPal uses for each option.--> 
					<input type="hidden" name="option_index" value="0">
					<input type="hidden" name="option_select0" value="50">
					<input type="hidden" name="option_amount0" value="5.00">
					<input type="hidden" name="option_select1" value="100">
					<input type="hidden" name="option_amount1" value="10.00">
					<input type="hidden" name="option_select2" value="500">
					<input type="hidden" name="option_amount2" value="50.00">
					<input type="hidden" name="option_select3" value="1000">
					<input type="hidden" name="option_amount3" value="100.00">
					
					<td>
						<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
			  		</td>
			  	</tr>
			</table>
		</form>
		
	</body>
</html>
