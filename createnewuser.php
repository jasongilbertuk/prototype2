<?php
	include "dbUtilities.php";
	include "mailUtilities.php";

	$error = "";
	$status = "";
	
	function AddUser($connection,$emailAddress,$password)
	{
		$result = false;
		$timestamp = time();
	
		$user = dbInsertUser($connection,$emailAddress,$password,$timestamp);
			
		if ($user)
		{
			$result = mailSendVerificationEmail($user);
			if (!$result)
			{	
				$error.="Failed in call to mailSendVerificationEmail<br/>";
			}
		}
		else
		{
			$error.="Failed in call to dbInsertUser.<br/>";
		}

		return $result;
	}

	if ($_POST["createuser"])
	{
		$connection = dbConnect ("localhost","web215-prototype","zaq12wsx","web215-prototype");
			
		
		$email = $_POST["email"];
		$password = $_POST["password"];
		$passwordconfirm = $_POST["passwordconfirm"];
		
		if ($password != $passwordconfirm)
		{
			$error = "Passwords do not match<br/>";
		}
		
		if (strlen($password) < 8)
		{
			$error = "Password must be a minimum of 8 characters<br/>";
		}
		
		
		if (dbUserExists($connection,$email))
		{
			$error = $error."That email address is already registered.</br>";
		}
		
		if (AddUser($connection, $email,$password))
		{
			$status = "Account created. An email containing a verification link has been sent. ";
			$status .= "You will be unable to login until you have clicked the link in the email.";
		}
		else
		{
			$error = $error."Failed in call to AddUser</br>";
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
		<h1>Create New User</h1>
		<div id="errors"><?php echo $error; ?></div>
		<div id="status"><?php echo $status; ?></div>
		<form method="post">
			<input id="email" type="email" name="email" placeholder="email address"></input>
			<input id="password" type="password" name="password" placeholder="password"></input>
			<input id="passwordconfirm" type="password" name="passwordconfirm" placeholder="confirm password"></input>
			<input id="submit" type="submit" name="createuser" value="Create User"></input>
		<p>Already a User? - click <a href="login.php">here</a> to Log In</p>
		<p>Forgot your password? - click <a href="passwordreminder.php">here</a> to get an email reminder.</p>
		</form>
	</body>
</html>