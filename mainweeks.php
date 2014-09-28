<?php
	session_start();
	
	include "dbUtilities.php";
	include "dateUtilities.php";
	
	
	if ($_POST["submit"]=="booking")
	{
			
		$start = $_POST["from1st"];
		$end = $_POST["to1st"];
		
		$date = strtotime($start);
		$startDate = date("Y-m-d",$date);

		$date = strtotime($end);
		$endDate = date("Y-m-d",$date);
		
		echo "<br/>start:".$startDate;
		echo "<br/>end:".$endDate;
		
		$public_holidays = dbGetPublicHolidays();
		$workingdays = getWorkingDays($startDate,$endDate,"Sat,Sun", $public_holidays);
		echo "This will require ".$workingdays." of leave.";
		
		
		
		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$query = "INSERT INTO absence_bookings (staff_id, start_date,end_date, type, status) VALUES (".$_SESSION["id"].",'".$startDate."','".$endDate."','firstChoice','pending_approval')";
		$result = mysqli_query($connection,$query);
		
		$start = $_POST["from2nd"];
		$end = $_POST["to2nd"];
		
		$date = strtotime($start);
		$startDate = date("Y-m-d",$date);

		$date = strtotime($end);
		$endDate = date("Y-m-d",$date);
		
		echo "<br/>start:".$startDate;
		echo "<br/>end:".$endDate;
		
		$public_holidays = dbGetPublicHolidays();
		$workingdays = getWorkingDays($startDate,$endDate,"Sat,Sun", $public_holidays);
		echo "This will require ".$workingdays." of leave.";
		
		
		$connection = dbConnect("localhost","web215-prototype","zaq12wsx","web215-prototype");
		$query = "INSERT INTO absence_bookings (staff_id, start_date,end_date, type, status) VALUES (".$_SESSION["id"].",'".$startDate."','".$endDate."','secondChoice','pending_approval')";
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
    $( "#from1st" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#to1st" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to1st" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from1st" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    $( "#from2nd" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#to2nd" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to2nd" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from2nd" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>
</head>
<body>
 
  <h1>Select main week choices</h1> 
 <form method="post">
 <h3>Main two weeks - first preference</h2>
 <label for="from1st">From</label>
<input type="text" id="from1st" name="from1st">
<label for="to1st">to</label>
<input type="text" id="to1st" name="to1st">
<br/>
<h3>Main two weeks - second preference</h2>
<label for="from2nd">From</label>
<input type="text" id="from2nd" name="from2nd">
<label for="to2nd">to</label>
<input type="text" id="to2nd" name="to2nd">
<br/>
<input type="submit" name="submit" value="booking" id="book"/>
 </form>
 
 <a href="home.php">Return to homepage</a>
</body>
</html>