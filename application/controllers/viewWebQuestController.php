<?php
	if(isset($_GET['activityNumber'])) {
		$activityId = (int)$_GET['activityNumber'];

		if(!is_int($activityId) || $activityId == 0) { //Just a quick check to see if the user doesn't randomly write some string on the url bar
			header("Location: ../activityMain/activity.php");
			exit;
		}
	
		require_once("../../../resources/models/Webquest.php");
		$webquest = new Webquest();
		$webquest->getWebQuestActivityFromServer($activityId); //Gets the activity from the SQL server ONLY and stores it to be instiantiated by a class object (Line below)
		$webquestObj = $webquest->getWebquestActivity();
		
		//check if you are logged in

		$userCreator = false;
		if($userInfoArray[0] == $webquestObj[14]) { //check if you are the user that made this activity
			$userCreator = true; //then allow the edit button to show, otherwise just show activity only
		}
		
		//Pass this along to use for edit and iframe window
		$_SESSION['activity'] = serialize($webquestObj); 
		
	} //if(isset($_GET['activity'])) 
	else {
		header("Location: ../activityMain/activity.php");
		exit;
	}
?>