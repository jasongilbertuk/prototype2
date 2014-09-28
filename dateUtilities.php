<?php

	function getWorkingDays($start_date, $end_date,$weekends = array('Sat','Sun'),Array $holidays=array()) 
	{ 
	
		if(!is_array($weekends))
			$weekends = explode(",",$weekends);
		
		
		
		$start_ts = strtotime($start_date); 
	    $end_ts = strtotime($end_date); 
	    $working_days = 0; 
	    $tmp_ts = $start_ts; 
	    
	    $publicHolidayDates = array();
	    foreach ($holidays as $publicHoliday)
	    {
	     	$publicHolidayDates[] = $publicHoliday["date"];
	    }
	    
	    
	    while ($tmp_ts <= $end_ts) { 
	        $tmp_day = date('D', $tmp_ts); 
	        $date = date("Y-m-d",$tmp_ts);
		
		     if (!(in_array($tmp_day,$weekends)) && !in_array($date, $publicHolidayDates)) { 
		        $working_days++; 
	        } 
	        $tmp_ts = strtotime('+1 day', $tmp_ts); 
	    } 
	    return $working_days; 
	}   
	
?>
