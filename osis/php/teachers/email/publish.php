<?php 
	
	include '../../../config.php';

	

	if (isset($_POST)) {
		$message = "";
		$email = $_POST['email'];
		$grade = $_POST['grade'];
		$body = 'Dear Parent, we wish to inform you that '.$_POST["cname"].' '.$_POST["sub"].' '.$_POST["tname"].' results for the '.$_POST["term"].' Academic Year is out. <br><br> Kindly visit <a href="www.gaecsip.com">www.gaecsip.com</a> and enter your login credentials to view your wards performance. <br><br>'; 

					
							if(updateResults($con, $grade,'results') != true)
							{
								$message .= "Unable to update query ".$con->error;
							}else{
								require '../../php_mailer/Exception.php';
								require '../../php_mailer/PHPMailer.php';
								require '../../php_mailer/SMTP.php';
							


								$mail = new PHPMailer\PHPMailer\PHPMailer();

								$mail->isSMTP();
								$mail->Host = "smtp.gmail.com";
								$mail->SMTPAuth = true;
								$mail->Username = "eliamev12@gmail.com";
								$mail->Password = 'kbills2all';
								$mail->Port 	= 465;
								$mail->SMTPSecure = "ssl";

								// Email Settings
								$mail->isHTML(true);
								$mail->setFrom("eliamev12@gmail.com","GAEC BASIC SCHOOL");
								foreach($_POST['email'] as $mails)
								{
									$mail->AddCC($mails);
								}
								
								
								// Content
								$mail->Subject = $_POST['cname'].' '.$_POST['sub'].' '.$_POST['tname'];
								$mail->Body = $body;

								if($mail->send())
								{
									$message .='Records Verified and Published';
								}else{
									$message .= 'Unable to send email message'.$con->error;
								}
							}
								
						
							
				 			
							$data = array('msg' => $message);
							echo json_encode($data);

			}	

			function updateResults($connect, $grade, $tablename)
			{
				$connection = $connect;
				$grade_id = $grade;
				$tbl = $tablename;

				foreach($grade_id as $results_id)
				{
					$update = $connection->query("UPDATE $tbl SET published =  1 WHERE gradeId = '$results_id'");						
				}
				return $update;	
			}	

		$con->close();
							

?>