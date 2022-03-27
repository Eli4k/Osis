<?php

	session_start();
	 if (isset($_GET['logout'])) {

	 	include '../config.php';

	 		$query = $con->query("UPDATE admin SET status = 0 WHERE admin_id = '".$_SESSION["uname"]."'");
	 	 	if ($query) {
	 				session_unset();
	 				session_destroy();
	 				header('Location: ../index.php?msg=Enter Username and Password to Login');
	 				exit();
	 				$con->close();
	 			}	else{
	 				echo $con->error;
	 			}
	 }

?>
