<?php
//通过时间戳比较两日期之差
function _date_diff($date1,$date2){
	$date1 = "2007-03-24";
$date2 = "2009-06-26";

$diff = abs(strtotime($date2) - strtotime($date1));

$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

printf("%d years, %d months, %d days\n", $years, $months, $days);
}

function _date_diff_object($date1,$date2){
$date1 = new DateTime("2007-03-24");
$date2 = new DateTime("2009-06-26");
$interval = $date1->diff($date2);
echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";

// shows the total amount of days (not divided into years, months and days like above)
echo "difference " . $interval->days . " days ";
}
