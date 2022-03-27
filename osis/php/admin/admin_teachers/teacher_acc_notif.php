<?php 
	
	if (!empty($query)) {
							while($row = $query->fetch_assoc())
							{
								// Email 
								include_once '../../php_mailer/Exception.php';
								include_once '../../php_mailer/PHPMailer.php';
								include_once '../../php_mailer/SMTP.php';

								$mail = new PHPMailer(true);

								$subject = "Teacher Account Created";

								$body = '<div><span style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; color: #BBBBBB;">
										<p>Hello, Mr/Mrs '.$fname.' '.$lname.', Your Teacher Information Portal has been created. Use your Login_id and Password provided below to login to our portal.</p><br>

										<p>Your Login Id is: '.$row["teacher_id"].'.<br>Your Password is: '.$row["password"].'</p>
										Login at <a href="localhost/www.schoolportal.com">www.gbsportal.com</a></div>
									<div><p>GAEC BASIC SCHOOL, Always with the Best</p></span></div>';

								$mail->isSMTP();
								$mail->Host = "smtp.gmail.com";
								$mail->SMTPAuth = true;
								$mail->Username = "eliamev12@gmail.com";
								$mail->Password = 'kbills2all';
								$mail->Port 	= 465;
								$mail->SMTPSecure = "ssl";

								// Email Settings
								$mail->isHTML(true);
								$mail->setFrom("eliamev12@gmail.com","GAEC BASIC SCHOOL Administration");
								$mail->addAddress($email); 
								
								// Content
								$mail->Subject = $subject;
								$mail->Body = $body;

										switch ($mail->send()) {
											case true:
												$data["insert_response"] .= "Record successfully created and Email notification sent";
												break;
											default:
												$data["insert_response"] .= "Record successfully but could not send Email notification. Please check network connectivity";
												break;			
											}	
									break;
							}
		
					}

?>