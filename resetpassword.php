<?php
	session_start();
	include "dbUtilities.php";
	
	if ($_GET["id"])
	{
		if ($_GET["verify"])
		{
			$id = $_GET["id"];
			$verify =  $_GET["verify"];
			
			$connection = dbConnect ("localhost","web215-prototype","zaq12wsx","web215-prototype");
			$user = dbGetUserByID($connection, $id);
			
			if (!$user)
			{
				die("Invalid reset request");
			}
			
			$_SESSION["id"] = $id;
		}
	}
	
	if ($_POST["resetPassword"])
	{
		$password = $_POST["password"];
		$passwordconfirm = $_POST["passwordconfirm"];
		$error = "";
		$status = "";
		
		if ($password != $passwordconfirm)
		{
			$error = "Passwords do not match<br/>";
		}
		
		if (strlen($password) < 8)
		{
			$error = "Password must be a minimum of 8 characters<br/>";
		}
		
		$user = dbGetUserByID($connection, $_SESSION["id"]);
		
		if ($user)
		{
			$user["password"] = $password;
			$user["hasValidated"] = TRUE;
			
			dbUpdateUser($connection,$user);
			
			$status = 'Password Reset. Click  <a href="login.php">here</a> to log in.';
		}
		
		$_SESSION["id"] = "";
		mysqli_close($connection);
	}
?>

<html>
	<head>
	</head>
	<body>	
		<h1>Reset Password</h1>
		
		<form method="post">
			<input id="password" type="password" name="password" placeholder="New password"></input>
			<input id="passwordconfirm" type="password" name="passwordconfirm" placeholder="confirm new password"></input>
			<input id="submit" type="submit" name="resetPassword" value="Reset Password"></input>
		</form>
		
		<div id="errors"><?php echo $errors; ?></div>
		<div id="status"><?php echo $status; ?></div>
	
	</body>
</html>