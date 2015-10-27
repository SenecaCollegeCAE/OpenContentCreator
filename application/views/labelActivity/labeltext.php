<?php
	session_start();
	require_once("../../../application/controllers/helpers/storedActivityInfo.php");
	
	echo $activityObj[1] . "<br /><br />";
	echo $activityObj[2] . "<br /><br />";
	echo $activityObj[3] . "<br /><br />";
	
	echo "Activity Image:<br />";
	echo $activityObj[5] . "<br /><br />";
	
	echo "Type of Labels:";
	echo "<ul>";
	foreach($activityObj[6] as $labels) {
		echo "<li>" . $labels . "</li>";
	}
	echo "</ul>";
?>