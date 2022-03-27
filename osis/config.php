<?php
	$password = "";
	$con = new mysqli("localhost","root","","schoolportal");
	if (!$con) {
		die("Could not connect to the Database".$con->connect_error);
	}
?>
