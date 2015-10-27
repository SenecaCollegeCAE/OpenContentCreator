<?php
	session_start();
	require_once("../../../application/controllers/helpers/storedActivityInfo.php");
	
	echo $activityObj[1] . "<br /><br />";
	echo $activityObj[2] . "<br /><br />";
	echo $activityObj[3] . "<br /><br />";
		
	$maxNumber = 0;
	for($i = 0; $i < count($activityObj[10]); $i++) {//get the total number of questions & answers that are not blank in the array
		if($activityObj[10][$i] != "")
			$maxNumber++;
	}
	
	for($i = 0; $i < $maxNumber; $i++) {
		echo ($i + 1) . ") " . $activityObj[10][$i] . "<br />";
		$tempArray = [];
		array_push($tempArray, $activityObj[11][$i]);
		array_push($tempArray, $activityObj[12][$i]);
		array_push($tempArray, $activityObj[13][$i]);
		array_push($tempArray, $activityObj[14][$i]);
		shuffle($tempArray);
		echo "a) " . $tempArray[0] . "<br />";
		echo "b) " . $tempArray[1] . "<br />";
		echo "c) " . $tempArray[2] . "<br />";
		echo "d) " . $tempArray[3] . "<br />";
		
		if($activityObj[15][$i] != "") {
			echo "Hint: " . $activityObj[15][$i] . "<br />";
		}
		else {
			echo "<br />";
		}
	}
?>