<?php

	include '../../../config.php';
	$del_msg = '';

	if (isset($_POST)) {
		$sid = $_POST["sid"];
		 $sql = "DELETE FROM students WHERE sid='$sid'";

			if($con->query($sql)){
				$del_msg.='Record Successfully Deleted';
			}else{
				 $del_msg.='Unable to Delete Record. Error:'.$con->error;
			}
	}
	$data = array("del"=>$del_msg);
	echo json_encode($data);
	$con->close();
 ?>
