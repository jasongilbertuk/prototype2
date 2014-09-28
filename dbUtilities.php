<?php

	function dbConnect($server, $user, $password, $database)
	{
		$connection = mysqli_connect($server, $user, $password, $database);
		if (mysqli_error($connection))
		{
			die("Could not connect to the database. Contact system administrator");
		}
		
		return $connection;
	}
	
	function dbGetUserByID($connection, $id)
	{
		$row = null;
		$query = "SELECT * FROM `users` WHERE `id` =".$id." LIMIT 1";
		$result = mysqli_query($connection, $query);
		
		if ($result)
		{
			$rows = mysqli_num_rows($result);
			if ($rows != 0)
			{
				$row = mysqli_fetch_array($result);
			}
		}
		return $row;
	}
	
	function dbUpdateUser($connection, $user)
	{
		$query = 'UPDATE users SET email="'.$user['email'].'",password="'.$user['password'].
					'",hasValidated='.$user['hasValidated'].',validationTimestamp='.$user['validationTimestamp'].' WHERE id='.$user['id'];
		$result = mysqli_query($connection, $query);
		
		return $result;
	}
	
	function dbInsertUser($connection, $email,$password, $timestamp)
	{
		
		$user = null;
		$query = "INSERT INTO `users` (`email`,`password`,`hasValidated`,`validationTimestamp`) 
				  VALUES ('".$email."','".$password."',FALSE,".$timestamp.")";
				  
				  
		$result = mysqli_query($connection, $query);
		if ($result)
		{
			$id = mysqli_insert_id($connection);	
			$user = dbGetUserByID($connection,$id);
		}
		
		return $user;
	}

	
	function dbGetUserByEmail($connection, $email)
	{
		$query = "SELECT * FROM users WHERE email ='".$email."' LIMIT 1";
		$result = mysqli_query($connection, $query);
		
		if ($result)
		{
			$rows = mysqli_num_rows($result);
			if ($rows != 0)
			{
				$row = mysqli_fetch_array($result);
			}
		}
		return $row;
	}


	function dbUserExists($connection, $emailAddress)
	{
		$userExists = false;
		
		if (dbGetUserByEmail($connection,$emailAddress))
		{	
			$userExists = true;
		}
			
		return $userExists;
	}
	
		
	function dbGetPublicHolidays()
	{
		$publicHolidays = Array();
		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$query = "SELECT * FROM public_holidays";
		
		$result = mysqli_query($connection,$query);
		if ($result)
		{
			while ($row = mysqli_fetch_array($result))
			{
				$publicHolidays[] = $row;
			}
		}
		
		return $publicHolidays;
	}
	
	function dbAddPublicHoliday($date,$comment)
	{	
		$dateTime = strtotime($date);
		$date = date("Y-m-d",$dateTime);
	
		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$query = "INSERT INTO public_holidays (date,comment) VALUES('".$date."','".$comment."')";
		
		$result = mysqli_query($connection,$query);
		return $result;
	}

	function dbGetGroups()
	{
		$groups = Array();
		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$query = "SELECT * FROM groups";
		
		$result = mysqli_query($connection,$query);
		if ($result)
		{
			while ($row = mysqli_fetch_array($result))
			{
				$groups[] = $row;
			}
		}
		
		return $groups;
	}
	
		function dbAddUserType($name)
	{	
		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$query = "INSERT INTO usertypes (name) VALUES('".$name."')";
		
		$result = mysqli_query($connection,$query);
		return $result;
	}
	
	function dbGetUserTypes()
	{
		$usertypes = Array();
		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$query = "SELECT * FROM usertypes";
		
		$result = mysqli_query($connection,$query);
		if ($result)
		{
			while ($row = mysqli_fetch_array($result))
			{
				$usertypes[] = $row;
			}
		}
		
		return $usertypes;
	}
	
	function dbAddGroup($name,$minstaff)
	{	
		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$query = "INSERT INTO groups (name,minstaff) VALUES('".$name."','".$minstaff."')";
		
		$result = mysqli_query($connection,$query);
		return $result;
	}
	
	function dbSetUserGroups($connection, $user,$groups)
	{
		$query = 'DELETE FROM usergrouprelationship WHERE userid = '.$user['id'];
		$result = mysqli_query($connection, $query);
		if (!result)
		{
			echo "ERROR";
		}
		
		foreach ($groups as $group)
		{
			$query = 'INSERT INTO usergrouprelationship (userid,groupid) VALUES ('.$user['id'].','.$group['id'].')';
			$result = mysqli_query($connection, $query);
			if (!$result)
			{
				echo "ERROR";
			}
		}
		
		
		return $result;
	}
	
		
	function dbSetUserTypes($connection, $user,$types)
	{
		$query = 'DELETE FROM usertyperelationship WHERE userid = '.$user['id'];
		$result = mysqli_query($connection, $query);
		if (!result)
		{
			echo "ERROR";
		}
		
		print_r($types);
		
		foreach ($types as $type)
		{
			echo "TYPE:".$type["id"]."<BR/>"; 
			$query = "INSERT INTO usertyperelationship (userid,typeid) VALUES (".$user['id'].",".$type['id'].")";
			echo $query;
			$result = mysqli_query($connection, $query);
			if (!$result)
			{
				echo "ERROR";
				echo mysqli_error($connection);
			}
		}
		
		
		return $result;
	}
	
	
	
	
	
	function dbClose($connection)
	{
		mysqli_close($connection);
	}

?>
