<?php
	//Global variables to tell if there are errors
	$searchError1 = $searchError2 = false;
	require_once("../../../resources/models/Activity.php");
	$activity = new Activity();
	
	//check if there is an activity session, this activity session is used for everything, edit and view activity, then unset it
	if(isset($_SESSION['activity'])) {
		unset($_SESSION['activity']);	
	}
	
	//Prepopulate values into the drop down menus
	if(empty($_POST)) {
		$allActivitiesCreatedByUser = $activity->getAllActitivesCreatedByUser($userInfoArray[0]);
		$allActivitiesCopiedByUser = $activity->getAllActivitiesCopiedByUser($userInfoArray[0]);
	}
	else {
		 switch(true) {
		 	case isset($_POST['activitySearchSubmit']):
		 		 
		 		//Validate the Search Form
		 		if(strlen($_POST['activitySearch']) == 0) {//if search is empty
		 			$searchError1 = true;
		 		}
		 		//End of Validate Search Form
		 		 
		 		if(!$searchError1) {
		 			$activitySearch = trim(filter_var($_POST['activitySearch'], FILTER_SANITIZE_STRING)); 				
		 			header("Location: ./activitysearch.php?search=" . $activitySearch);
		 			exit;
		 		}
		 		 
		 		break;
		 	
		 	case isset($_POST['activitySelfCopySubmit']):
		 		require_once("../../controllers/helpers/copyYourOwnActivity.php");
		 		header("Location: stuff2.php");
		 		exit;
		 		break;
		 		
		 	case isset($_POST['activityViewEditSubmit']):
		 		if($_POST['activityViewEdit'] != 0) {
			 		$activityType = $activity->getTypeOfActivity($_POST['activityViewEdit']);	
	
					switch($activityType) {
						case 'webq':
							header("Location: ../webquest/webquestactivity.php?activityNumber=" . $_POST['activityViewEdit']);
							exit;
							break;
							
						case 'trivia':
							header("Location: ../trivia/triviaactivity.php?activityNumber=" . $_POST['activityViewEdit']);
							exit;
							break;
							
						case 'label':
							header("Location: ../labelActivity/labelactivity.php?activityNumber=" . $_POST['activityViewEdit']);
							exit;
							break;
							
						default:
					}
		 		}
		 		break;
		 		
		 	case isset($_POST['activityCopyViewEditSubmit']):
		 		header("Location: stuff4.php");
		 		exit;
		 		break;
		 		
		 	default:
		 		
		 }
	}
?>