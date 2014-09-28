<?php
	session_start();
	
	include "dbUtilities.php";
	
	// Q. Is the user already logged in? 
	if ($_SESSION["id"])
	{
		//A. Yes. So redirect user to the homepage, where they can logout if required.
		header("Location: home.php");
	}
	
	if ($_POST["login"])
	{
		$email = $_POST["email"];
		$password = $_POST["password"];
		
		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$user = dbGetUserByEmail($connection,$email);
		
		if ($user)
		{
			if ($user["password"] == $password)
			{
				echo "Passwords match";
				$_SESSION["id"] = $user["id"];
				$_SESSION["type"] = $user["type"];
				header("Location: home.php");
			}
			else
			{
				echo "Passwords don't match";
			}
		}
		else
		{
			echo "no user exists with this email address.";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Absence Management System">
    <meta name="author" content="Sam Gilbert">
    <link rel="icon" href="../../favicon.ico">

    <title>Absence Management - Login</title>
  </head>

  <body>
  	<h1>Log In</h1>
	<form method="post">
		<input id="email" type="email" name="email" placeholder="email address"></input>
		<input id="password" type="password" name="password" placeholder="password"></input>
		<input id="submit" type="submit" name="login" value="Log In"></input>
		
		<p>New User? - click <a href="createnewuser.php">here</a> to create an account</p>
		<p>Forgotten your password? - click <a href="passwordreminder.php">here</a> to reset</p>
		
	</form>
  </body>
</html>

