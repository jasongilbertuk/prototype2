<?php
	include "dbUtilities.php";
	
	$error = "";
	$status = "";
	
	$id = $_GET["id"];
	$verification = $_GET["verify"];
	$userIsValidated = FALSE;
	
	$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
	
	$user = dbGetUserByID($connection,$id);
	if ($user != null)
	{
	 	$email = $user["email"];
	 	$verificationCheck = md5(md5($email).md5($user['validationTimestamp']));
	 	
		if ($verification == $verificationCheck)
		{
			$user["hasValidated"] = TRUE;
			if ( dbUpdateUser($connection,$user))
			{
				$userIsValidated = TRUE;
				$status = "Account has been validated. Click <a href='login.php'>here</a> to Log In.";
			}
		}
	}
	else
	{
		$error.="Verification Error: The user does not exist. Please contact the system administrator.</br>";
	}
	 
?>

<html>
	<head>
	</head>
	<body>	
		<h1>VERIFY NEW USER</h1>
		
		<div id="status"><?php echo $status; ?></div>
		<div id="error"><?php echo $error; ?></div>
		
	</body>
</html>