<?php

function mailSendVerificationEmail($user)
{
	$subject = 'Absence Monitoring Account Verification';

	// MD5 of email address
	$verificationString = md5(md5($user["email"]).md5($user["validationTimestamp"]));

	$message = '
			<html>
				<head>
  					<title>Absence Monitoring Account Verification</title>
				</head>
							 
				<body>
					<p>Please click <a href="http://79.170.44.215/sammuch.com/prototype/verifynewuser.php?id='.$user["id"].'&verify='.$verificationString.'">here</a> to complete your account creation.</p>
				</body>
			</html>';

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Absence Monitoring System <ams@example.com>' . "\r\n";
	
	// Mail it
	$result = mail($user["email"], $subject, $message, $headers);
	return $result;
}


	function mailSendPasswordReminderMail($user)
	{
			$id = $user["id"];
			
			$verificationString = md5(md5($user["email"]).md5($user["validationTimestamp"]));
			$subject = 'Absence Monitoring Account Password Reminder';

			// message
			$message = '
					<html>
						<head>
  							<title>Password Reminder</title>
						</head>
							 
						<body>
							<p> Please click <a href="http://79.170.44.215/sammuch.com/prototype/resetpassword.php?id='.$id.'&verify='.$verificationString.'">here</a> to reset your password.</p> 
						</body>
					</html>';

			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			// Additional headers
			$headers .= 'From: Absence Monitoring System <ams@example.com>' . "\r\n";
	
			// Mail it
			$reminderSent = mail($user["email"], $subject, $message, $headers);
			return $reminderSent;
	}

?>