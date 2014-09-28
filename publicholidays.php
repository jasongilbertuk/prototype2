<?php
	session_start();
	
	include "dbUtilities.php";

	if ($_GET["delete"])
	{
		$id = $_GET["delete"];

		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$query = "DELETE FROM public_holidays WHERE id=".$id; 
		$result = mysqli_query($connection,$query);
	}
	
	if ($_POST["submit"]=="Set")
	{
		dbAddPublicHoliday($_POST["from"],$_POST["comment"]);	
	}
	
	if ($_POST["submit"]=="Query")
	{
		$publicHolidays = dbGetPublicHolidays();
		
		
		 $table = '<table >
  				<tr>
    				<th>Date</th>
    				<th>Comment</th>
    				<th>Click to remove</th> 
  				</tr>';
		
		foreach ($publicHolidays as $publicHoliday)
		{
			$holiday_list.=$publicHoliday["date"]." - ".$publicHoliday["Comment"]."<br/>";
			$table.="<tr>
		   				 <td>".$publicHoliday["date"]."</td>
		   				 <td>".$publicHoliday["Comment"]."</td> 
    					 <td><a href='publicholidays.php?delete=".$publicHoliday["id"]."'>delete</a></td></tr>";

		}
		$table.="</table>";
	}

if ($_POST["submit"]=="delete")	
{
	echo "Delete";
}
	

?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Datepicker - Select a Date Range</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
  });
  </script>
</head>
<body>
 
 <h1>Administration: Public Holidays</h1> 
 <form method="post">
<label for="Date">Date</label>
<input type="text" id="from" name="from">
<label for="Comment">Comment</label>
<input type="text" id="comment" name="comment">
<input type="submit" name="submit" value="Set" id="publicholiday"/>
<input type="submit" name="submit" value="Query" id="querypublicholiday"/>
 </form>
 
 <form method="post">
 <div id="holidaylist">
 	<?php echo $table;?>
 </div>
 </form>
 <a href="home.php">Return to homepage</a>
 

 
</body>
</html>