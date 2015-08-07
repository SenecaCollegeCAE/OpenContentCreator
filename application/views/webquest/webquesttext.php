<?php
	session_start();
	require_once("../../../application/controllers/helpers/storedActivityInfo.php");
	
	echo $activityObj[1] . "<br /><br />";
	echo $activityObj[2] . "<br /><br />";
	echo $activityObj[3] . "<br /><br />";
	echo strip_tags($activityObj[5]) . "<br /><br />";
	echo strip_tags($activityObj[6]) . "<br /><br />";
	
	foreach($activityObj[7] as $links) {
		echo $links . "<br />";
	}
	echo "<br />";
	
	foreach($activityObj[8] as $tasks) {
		echo nl2br($tasks) . "<br />";
	}
	echo "<br />"; 
	
	foreach($activityObj[9] as $questions) {
		echo nl2br($questions) . "<br />";
	}
	echo "<br />";
	
	echo strip_tags($activityObj[10]) . "<br /><br />";
?>