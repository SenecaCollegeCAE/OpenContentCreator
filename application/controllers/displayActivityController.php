<?php
	if(isset($_GET['activityNumber'])) {
		$activityId = (int)$_GET['activityNumber'];
				
		require_once("../../resources/models/Activity.php");
		require_once("../../resources/models/Webquest.php");
		require_once("../../resources/models/Trivia.php");
		require_once("../../resources/models/Label.php");
		$activity = new Activity();
		$activityType = $activity->getActivityTypeWithoutLoggingIn($activityId);
		
		if($activityType != "") {
			switch($activityType) {
				case "webq":
					$finalActivity = new Webquest();
					$finalActivity->getWebQuestActivityFromServerWithoutLogin($activityId);
					$finalActivityObj = $finalActivity->getWebquestActivity();
					break;
					
				case "trivia":
					$finalActivity = new Trivia();
					$finalActivity->getTriviaActivityFromServerWithoutLogin($activityId);
					$finalActivityObj = $finalActivity->getTriviaActivity();
					break;
					
				case "label":
					$finalActivity = new Label();
					$finalActivity->getLabelActivityFromServerWithoutLogin($activityId);
					$finalActivityObj = $finalActivity->getLabelActivity();
					break;
					
				default:
			}
			$_SESSION['activity'] = serialize($finalActivityObj);
			//var_dump($finalActivityObj);
		}
		else {
			header("Location: ../index.php");
			exit;
		}
	}
	else {
		//redirect back to homepage
	}
?>