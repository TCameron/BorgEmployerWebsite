<?php
	//Protects against SQL Injections. Very important security feature for log in.
	function make_safe($variable) {
		$variable = mysql_real_escape_string(trim($variable));
		return $variable;
	}
?>