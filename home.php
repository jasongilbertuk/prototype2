<?php
	session_start();
	
	if (!$_SESSION["id"])
	{
		header("Location: login.php");
	}
	
	if ($_POST["logout"])
	{
		$_SESSION["id"] = "";	
		header("Location: login.php");
	}
	
?>


<html>
	<head>
	</head>
	<body>	
		<h1>Home</h1>
		
		<p>
			<a href="mainweeks.php">Select main week choices</a>
		</p>
		<p>
			<a href="bookLeave.php">Book ad-hoc absence</a>
		</p>
		


		<?php 
			if ($_SESSION["type"] != "administrator")
			{
				echo '		
				<p>
					<a href="publicholidays.php"> Administrator - Define public holidays </a>
				</p>
				<p>
					<a href="adminCreateNewUser.php"> Administrator - Create new user </a>
				</p>
				<p>
					<a href="adminUserTypes.php"> Administrator - User Types </a>
				</p>
				<p>
					<a href="adminGroups.php"> Administrator - Groups </a>
				</p>';
			}
		?>
		<form method="post">
			<input type="submit" name="logout" value="Log Out!" id="logout"></input>
		</form>
	
	</body>
</html>