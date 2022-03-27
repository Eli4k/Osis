<?php

include '../../../../config.php';

$message = "";

								require '../../../php_mailer/Exception.php';
								require '../../../php_mailer/PHPMailer.php';
								require '../../../php_mailer/SMTP.php';


	foreach($_POST["tid"] as $record)
	{
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$sql = $con->query("SELECT * FROM teachers WHERE tid = '".$record."'");

		foreach($sql as $info)
		{
			$gender="";
			if ($info["gender"] == "male") {
				$gender.="Mr.";
			}else{
				$gender .="Mrs.";
			}
			$body = '<p>Hello '.$gender.' '.$info["last_name"].', your Information Portal account has been successfully created. Kindly visit <a href="localhost/schoolportal">www.gaecsip.com</a> and Enter to Your Login credentials.</p>
				<p>Your Password and User Id are added in the message below</p>
				<p>Password: '.$info["password"].'<br>
				   User Id: '.$info["teacher_id"].'</p>
				<p>GAEC BASIC SCHOOL always with the best</p>';

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
								$mail->addAddress($info["email"]);

								// Content
								$mail->Subject = "Account Information";
								$mail->Body = $body;

								if($mail->send())
								{
									$con->query("UPDATE teachers SET notified = 1 WHERE tid = '".$info["tid"]."'");
									$message ='Email notifications has been successfully sent';
								}else{
									$message = 'Unable to send email message. Server: Error'.$con->error.' Email error:'.$mail->ErrorInfo;
								}
				}
		}

		$data = array('msg' => $message);
		echo json_encode($data);

?>
