<?php
	session_start();
	
	include "dbUtilities.php";

	if ($_GET["delete"])
	{
		$id = $_GET["delete"];

		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$query = "DELETE FROM usertypes WHERE id=".$id; 
		$result = mysqli_query($connection,$query);
	}
	
	if ($_POST["submit"]=="Set")
	{
		dbAddUserType($_POST["name"]);	
	}
	
	if ($_POST["submit"]=="Query")
	{
		$usertypes = dbGetUserTypes();
		
		
		 $table = '<table >
  				<tr>
    				<th>User Type</th>
    				<th>Click to remove</th> 
  				</tr>';
		
		foreach ($usertypes as $usertype)
		{
			$table.="<tr>
		   				 <td>".$usertype["name"]."</td>
		   				 <td><a href='adminUserTypes.php?delete=".$userType["id"]."'>delete</a></td></tr>";

		}
		$table.="</table>";
	}
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Administer Groups</title>
</head>
<body>
 
 <h1>Administration: User Types</h1> 
 
 <form method="post">
<label for="groupname">User Type</label>
<input type="text" id="name" name="name">
<input type="submit" name="submit" value="Set" id="createusertype"/>
<input type="submit" name="submit" value="Query" id="queryusertypes"/>
 </form>
 
 <form method="post">
 <div id="grouplist">
 	<?php echo $table;?>
 </div>
 </form>
 <a href="home.php">Return to homepage</a>
 

 
</body>
</html>