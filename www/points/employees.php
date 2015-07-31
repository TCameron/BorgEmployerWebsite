<?php
include_once("../functional/check.php"); 
include_once("../functional/db.php");
check_p();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Borg Points - Employees list</title>
	<link href="../../css/borgstyles.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8"/>
	<link href="../../css/style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8"/>

</head>
<body id="index">	

	<?php
	include("nav.html");
	?>

	<!--Used for populating the table of employees that are registered under the currently logged in manager-->
	<?php
		
		$connection = dbConnect('pointemployees');
		$id = $_SESSION['id'];
		
		$sql = "SELECT * FROM pointemployees WHERE id='$id' ORDER BY name";
		$result = mysql_die($sql, '');
		$verify = mysql_num_rows($result);  
	
		if($verify > 0){
			
			//Creates the table of employees for the ID of the currently logged in user.
			?>
			<div id="pagewrap">
	      		<div id="body">
					<table class="tablesorter" cellpadding="1" cellspacing="1" id="employees">
						<thead>
							<th abbr="php_col">Name</th>
							<th abbr="php_col">Email</th>
							<th abbr="php_col">Start Date</th>
							<th abbr="php_col">Birth Date</th>
							<th abbr="butt_col">Points</th>
							<th abbr="butt_col">Edit</th>
						</thead>
						<tbody>
						<?php 
						while ($row = mysql_fetch_array($result)) {
						?>
							<tr>
								<td><?php print $row['name']; ?></td>
								<td><?php print $row['email']; ?></td>
								<td><?php print $row['start'].'/'.$row['syear']; ?></td>
								<td><?php print $row['birth'].'/'.$row['byear']; ?></td>
								<td>
									<form>
										<input type="button" style="width:100%" onclick="location.href='givepoints.php'" value=<?php print $row['points']; ?> />
									</form>
								</td>
								<td>
									<form>
										<input type="button" style="width:100%" onclick="location.href='editemployee.php'" value="Edit" />
									</form>
								</td>
							</tr>
						</tbody>
						<?php } ?>
					
					</table>
				</div>
			</div>
		<?php	
		} else {
			
			echo "No employees found for you</br>";
			
		}
		
		mysql_close($connection);
	?>
	
</body>
</html>