<?php
	$activityNumber = intval($_POST['activitySelfCopy']);
	
	if(is_int($activityNumber) && $activityNumber != 0) {
		require_once("../../../resources/models/Activity.php");
		$activity = new Activity();
		$activity->getYourOwnActivityAndMakeACopy($activityNumber, $userInfoArray[0]);
		
		header("Location: ../../views/activityMain/activity.php?copy=true");
		exit;
	}
	else {
		header("Location: ../../views/activityMain/activity.php?copy=false");
		exit;
	}
?>