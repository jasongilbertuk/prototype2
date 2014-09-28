<?php
	session_start();
	
	include "dbUtilities.php";

	if ($_GET["delete"])
	{
		$id = $_GET["delete"];

		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$query = "DELETE FROM groups WHERE id=".$id; 
		$result = mysqli_query($connection,$query);
	}
	
	if ($_POST["submit"]=="Set")
	{
		dbAddGroup($_POST["groupname"],$_POST["groupmin"]);	
	}
	
	if ($_POST["submit"]=="Query")
	{
		$groups = dbGetGroups();
		
		
		 $table = '<table >
  				<tr>
    				<th>Group Name</th>
    				<th>Min Staffing Level</th>
    				<th>Click to remove</th> 
  				</tr>';
		
		foreach ($groups as $group)
		{
			$table.="<tr>
		   				 <td>".$group["name"]."</td>
		   				 <td>".$group["minstaff"]."</td> 
    					 <td><a href='adminGroups.php?delete=".$group["id"]."'>delete</a></td></tr>";

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
 
 <h1>Administration: Add Group</h1> 
 
 <form method="post">
<label for="groupname">Group Name</label>
<input type="text" id="groupname" name="groupname">
<label for="groupmin">Minimum Staffing Level</label>
<input type="numbert" id="groupmin" name="groupmin">
<input type="submit" name="submit" value="Set" id="creategroup"/>
<input type="submit" name="submit" value="Query" id="querygroups"/>
 </form>
 
 <form method="post">
 <div id="grouplist">
 	<?php echo $table;?>
 </div>
 </form>
 <a href="home.php">Return to homepage</a>
 

 
</body>
</html>