<?php
session_start();


include '../config.php';


if (isset($_POST['log_as'])) {

	$uname = $con->real_escape_string($_POST["username"]);
	$log_type = $con->real_escape_string($_POST["log_as"]);
	$pwd = $con->real_escape_string($_POST["password"]);

		if (empty($uname) || empty($pwd) || empty($log_type)) {
		 	header("Location: ../index.php?msg=Fields are Empty");
		 	$con->close();
		 	exit();
		 } else{

		 	if ($log_type == 1) {
		 			$sql = $con->query("SELECT * FROM students WHERE student_id ='$uname'");
		 			$result = $sql->num_rows;

		 		if (empty($result)) {
		 			header("Location: ../index.php?msg=Username does not Exist");
		 			exit();
		 		}else{
		 			$row = $sql->fetch_assoc();
		 			if ($pwd !== $row["password"]) {
		 				header("Location: ../index.php?msg=Password does not match");
		 				exit();
		 			}else{
		 				$_SESSION['sid'] = $row['sid'];
		 				$_SESSION['uname'] = $row['student_id'];
		 				$_SESSION['fullname'] = $row['first_name']." ".$row['middle_name']." ".$row['last_name'];
		 				$_SESSION['loggedIn'] = "yes";
						$_SESSION['student_class'] = $row['c_id'];
						$_SESSION['stream'] = $row['s_id'];
		 				$con->query("UPDATE students SET status = 1 WHERE student_id = '".$_SESSION["uname"]."'");
		 				header('Location: ../pages/students-page/index.php');
		 			}
		 		}
		 	}

	// 	 	// Teacher Login

		 	elseif ($log_type == 2) {
		 			$sql = $con->query("SELECT * FROM teachers WHERE teacher_id ='$uname'");
		 			$t_result = $sql->num_rows;

		 		if (empty($t_result)) {
		 			header("Location: ../index.php?msg=Username does not Exist");
		 			exit();
		 		}else{
		 			$row = $sql->fetch_assoc();
		 			if ($pwd !== $row["password"]) {
		 				header("Location: ../index.php?msg=Password does not match");
		 				exit();
		 			}else{
		 				$_SESSION['tid'] = $row['tid'];
		 				$_SESSION['uname'] = $row['teacher_id'];
		 				$_SESSION['fullname'] = $row['first_name']." ".$row['middle_name']." ".$row['last_name'];
		 				$_SESSION['loggedIn'] = "yes";
		 				$con->query("UPDATE teachers SET  status = 1 WHERE teacher_id = '".$_SESSION["uname"]."'");
		 				header('Location: ../pages/teachers-page/index.php');
		 			}
		 		}
		 	}

		 	// Admin

		 	elseif ($log_type == 3) {
		 			$sql = $con->query("SELECT * FROM admin WHERE admin_id ='$uname'");
		 			$a_result = $sql->num_rows;

		 		if (empty($a_result)) {
		 			header("Location: ../index.php?msg=Username does not Exist");
		 			exit();
		 		}else{
		 			$row = $sql->fetch_assoc();
		 			if ($pwd !== $row["password"]) {
		 				header("Location: ../index.php?msg=Password does not match");
		 				exit();
		 			}else{
		 				$_SESSION['aid'] = $row['ad_id'];
		 				$_SESSION['uname'] = $row['admin_id'];
		 				$_SESSION['fullname'] = $row['first_name']." ".$row['middle_name']." ".$row['last_name'];
		 				$_SESSION['loggedIn'] = "yes";
		 				header('Location: ../pages/admin/index.php');
		 				$con->query("UPDATE admin SET  status = 1 WHERE admin_id = '".$_SESSION["uname"]."'");
		 			}
		 		}
		 	}else{ header("Location: ../pages/admin-page/index.php?msg= Select an option to login");
		 	 		exit();
		 	 	}

	}
		}else{
			header('Location: ../pages/admin/index.php?msg=Enter Username and Password');
		}



?>
