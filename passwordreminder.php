<?php
	include "dbUtilities.php";
	include "mailUtilities.php";

	if ($_POST["passwordreminder"])
	{
		$connection = dbConnect ("localhost","web215-prototype","zaq12wsx","web215-prototype");

		$email = $_POST["email"];
		
		$user = dbGetUserByEmail($connection,$email);
		if ($user)
		{
			$user["validationTimestamp"] = time();
			$user["hasValidated"] = FALSE;
			$verificationString = md5(md5($emailAddress).md5($user["validationTimestamp"]));
			if (mailSendPasswordReminderMail($user))
			{
				$status = "A password reminder has been sent to your email account";
			}
			else
			{
				$status = "An error has occured. Please contact the system administrator.";
			}
		}
		else
		{
			$status = "No user found with this email address.";
		}
		dbClose($connection);
	}
?>

<html>
	<head>
		<style>
			#errors {
				color:red;
				border 1px solid grey;
				width:0 auto;
			}
		</style>

	</head>
	<body>	
		<h1>Password Reminder</h1>
		<div id="status"><?php echo $status; ?></div>
		<form method="post">
			<input id="email" type="email" name="email" placeholder="email address"></input>
			<input id="submit" type="submit" name="passwordreminder" value="Mail my Password"></input>
		<p>Remembered your password? - click <a href="login.php">here</a> to Log In</p>
		</form>
	</body>
</html>