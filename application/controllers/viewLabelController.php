<?php
	if(isset($_GET['activityNumber'])) {
		$activityId = (int)$_GET['activityNumber'];
		
		if(!is_int($activityId) || $activityId == 0) { //Just a quick check to see if the user doesn't randomly write some string on the url bar
			header("Location: ../activityMain/activity.php");
			exit;
		}
		
		require_once("../../../resources/models/Label.php");
		$label = new Label();
		$label->getLabelActivityFromServer($activityId); //Gets the activity from the SQL server ONLY and stores it to be instiantiated by a class object (Line below)
		$labelObj = $label->getLabelActivity();
		
		//check if you are logged in
		
		$userCreator = false;
		if($userInfoArray[0] == $labelObj[13]) { //check if you are the user that made this activity
			$userCreator = true; //then allow the edit button to show, otherwise just show activity only
		}
		
		//Pass this along to use for edit and iframe window
		$_SESSION['activity'] = serialize($labelObj);
	}
	else {
		header("Location: ../activityMain/activity.php");
		exit;
	}
?>