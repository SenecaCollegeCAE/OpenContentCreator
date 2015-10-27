<?php
	$activityNumber = intval($_GET['activityNumber']);
	
	if(is_int($activityNumber)) {
		require_once("storedUserInfo.php");
		require_once("../../../resources/models/Activity.php");
		$activity = new Activity();
		$activity->getActivityThatIsNotYoursAndMakeACopy($activityNumber, $userInfoArray[0]);

		header("Location: ../../views/activityMain/activity.php?copy=true");
		exit;
	}
	else {
		header("Location: ../../views/activityMain/activity.php?copy=false");
		exit;
	}
?>