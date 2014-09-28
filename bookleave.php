<?php
	session_start();
	
	include "dbUtilities.php";
	include "dateUtilities.php";
	
	
	if ($_POST["submit"]=="booking")
	{
			
		$start = $_POST["from"];
		$end = $_POST["to"];
		
		$date = strtotime($start);
		$startDate = date("Y-m-d",$date);

		$date = strtotime($end);
		$endDate = date("Y-m-d",$date);
		
		$public_holidays = dbGetPublicHolidays();
		$workingdays = getWorkingDays($startDate,$endDate,"Sat,Sun", $public_holidays);
		echo "This will require ".$workingdays." of leave.";
		
		
		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$query = "INSERT INTO absence_bookings (staff_id, start_date,end_date, type, status) VALUES (".$_SESSION["id"].",'".$startDate."','".$endDate."','adhoc','pending_approval')";
		$result = mysqli_query($connection,$query);
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
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>
</head>
<body>
 
 <h1>Book Absence</h1>
 <form method="post">
<label for="from">From</label>
<input type="text" id="from" name="from">
<label for="to">to</label>
<input type="text" id="to" name="to">
<input type="submit" name="submit" value="booking" id="book"/>
 </form>
 
 <a href="home.php">Return to homepage</a>
 
</body>
</html>