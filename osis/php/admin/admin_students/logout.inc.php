<?php 

	session_start();
	 if (isset($_GET['logout'])) {

	 	// $con = new mysqli("localhost","root","","schoolportal");

	 	// 	$query = $con->query("UPDATE students SET status = 0 WHERE student_id = '".$_SESSION['uname']."'");
	 	// 	if ($query) {
	 				session_unset();
	 				session_destroy();
	 				header('Location: ../../index.php?msg=Enter Username and Password to Login');
	 				exit();
	 			// 	$con->close();
	 			// }	else{
	 			// 	echo $con->error;
	 			// }
	 }

?>