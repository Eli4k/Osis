<?php

	include '../../../config.php';


	if (isset($_POST)) {

		$std = $_POST["id"];
		$emails = $_POST["email"];

		$message = "";

		$body = 'Hello, we wish to inform you that End Of Term Students Academic Year Terminal Reports are out. <br><br> Kindly visit <a href="www.gaecsip.com">www.gaecsip.com</a> and enter your login credentials to view your wards performance. <br><br>';

							if(!updateResults($con, $std,'assessment'))
							{
								$message .= "Unable to update query ".$con->error;
								exit();
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
								foreach($emails as $mails)
								{
									$mail->AddCC($mails);
								}


								// Content
								$mail->Subject = "END OF TERM EXAM";
								$mail->Body = $body;

								if($mail->send())
								{
									$message .='Results have been Published successsfully';
								}else{
									$message .= 'Unable to send email message: '.$mail->ErrorInfo;
								}
							}

							$data = array('msg' => $message);
							echo json_encode($data);

			}

			function updateResults($connect, $student,$tablename)
			{
				$connection = $connect;
				$student = $student;
				$tbl = $tablename;

				foreach($student as $id)
				{

						$update = $connection->query("UPDATE $tbl SET PUBLISHED =  1 WHERE student_id = '$id'");
				}

				return $update;
			}

		$con->close();


?>
