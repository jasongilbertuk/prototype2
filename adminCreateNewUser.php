<?php
	include "dbUtilities.php";
	include "mailUtilities.php";

	$error = "";
	$status = "";
	
	function AddUser($connection,$emailAddress,$password,$groups,$usertypes)
	{
		$result = false;
		$timestamp = time();
	
		$user = dbInsertUser($connection,$emailAddress,$password,$timestamp);
		
		dbSetUserGroups($connection,$user,$groups);
		dbSetUserTypes($connection,$user,$usertypes);
			
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
		
		echo "hello";
		print_r($_POST["chk_types"]);
		
		if (AddUser($connection, $email,$password,$_POST["chk_group"],$_POST["chk_types"]))
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
	
	$groups = dbGetGroups();
	
	$groupscheckboxhtml = "";
	
	foreach ($groups as $group)
	{
		$groupscheckboxhtml.='<input type="checkbox" name="chk_group[]" value="'.$group["id"].'" />'.$group["name"].'<br />';
	}
	
	$usertypes = dbGetUserTypes();
	
	$usertypescheckboxhtml = "";
	
	foreach ($usertypes as $usertype)
	{
		$usertypescheckboxhtml.='<input type="checkbox" name="chk_types[]" value="'.$usertype["id"].'" />'.$usertype["name"].'<br />';
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
	
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css"></link>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css"></link>
 
  <script>
  $(function() {
    $( "#joined" ).datepicker({
      defaultDate: "-1y",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
  });
  </script>

	
		
		<h1>Admin Create New User</h1>
		<div id="errors"><?php echo $error; ?></div>
		<div id="status"><?php echo $status; ?></div>
		<form method="post">
			<input id="email" type="email" name="email" placeholder="email address"></input>
			<input id="password" type="password" name="password" placeholder="password"></input>
			<input id="passwordconfirm" type="password" name="passwordconfirm" placeholder="confirm password"></input>
			<input id="annualLeaveDays" type="number" name="annualLeaveDays" placeholder="Annual Leave Entitlement"></input>
			<label for="from">Date Joined</label>
			<input type="text" id="joined" name="joined">
			<!--TODO: User type -->
			<br/>
			<?php echo $groupscheckboxhtml; ?>
			<br/>
			<?php echo $usertypescheckboxhtml; ?>
			<input id="submit" type="submit" name="createuser" value="Create User"></input>
		</form>
	</body>
</html>