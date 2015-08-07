<?php
	require_once("../../../resources/models/Webquest.php"); //call the webquest model class, it also call the parent activity model class
	$webquest = new Webquest();
	
	require_once("./webquestSessions.php"); //clear the previous session of submits if any before setting a new one
	unsetSessions();
	
	//Edit mode presets *************************************************************************************************
	if(isset($_GET['activityNumber']) && isset($activityObj)) {
		$_POST['activityNumber'] = $activityObj[0];
		
		//check if activity belongs to you before you can edit it, otherwise redirect back to main page
		if(isset($_POST['activityNumber']) && $_POST['activityNumber'] != "") {
			if(!$webquest->checkIfActivityIsYours($userInfoArray[0], $_POST['activityNumber'])) { //returns true or false
				header("Location: ../activityMain/activity.php");
				exit;	
			}
			else { //activity belongs to you, populate the $_POST fields with you info
				$webquest->setWebquestActivityForEdit($activityObj); //set the webquest class obj with the edit info and set the $_POST info as well
				$_POST['webquestTitle'] = $activityObj[1];
				$_POST['webquestDescription'] = $activityObj[2];
				$_POST['webquestTitleImage'] = $activityObj[3];
				setImageName($_POST['webquestTitleImage']);
				$_POST['webquestThemeColor'] = $activityObj[4];
				$_POST['webquestLearningOutcomes'] = $activityObj[5];
				$_POST['webquestOverview'] = $activityObj[6];
				$_POST['webquestLink'] = $activityObj[7];
				clearAndSetLinks($_POST['webquestLink']);
				$_POST['webquestTask'] = $activityObj[8];
				clearAndSetTasks($_POST['webquestTask']);
				$_POST['webquestQuestion'] = $activityObj[9];
				clearAndSetQuestions($_POST['webquestQuestion']);
				$_POST['webquestEvaluation'] = $activityObj[10];
				$_POST['webquestPublishMethod'] = $activityObj[11];
				$_POST['webquestCreativeCommon'] = $activityObj[12];
				$_POST['webquestAllowCopy'] = $activityObj[13];
				
			}
		}
	}
	//End of edit mode presets *************************************************************************************************
	
	//Global variables to tell if there are errors, and set other flags for other things *****************************************************************************************************
	$webquestTitleError1 = $webquestTitleError2 = $webquestTitleError3 = false;
	$webquestDescriptionError1 = $webquestDescriptionError2 = false;
	$webquestImageError1 = false;
	$webquestImageError2 = false;
	$webquestLearningOutcomeError1 = false;
	$webquestOverviewError1 = false;
	
	$webquestLinkErrors1 = [];
	$webquestLinkErrors1[0] = false;
	$webquestOverallLinkError = false; //instead of looping and checking all 10
	
	$webquestTaskErrors1 = [];
	$webquestTaskErrors1[0] = false;
	$webquestTaskErrors2 = [];
	$webquestTaskErrors2[0] = false;
	$webquestOverallTask1Error = false; //instead of looping and checking all 10
	$webquestOverallTask2Error = false; //instead of looping and checking all 10
	
	$webquestQuestionErrors1 = [];
	$webquestQuestionErrors1[0] = false;
	$webquestQuestionErrors2 = [];
	$webquestQuestionErrors2[0] = false;
	$webquestOverallQuestion1Error = false; //instead of looping and checking all 10
	$webquestOverallQuestion2Error = false; //instead of looping and checking all 10
	
	$webquestEvaluationError1 = false;
	
	//set the number of clicks pressed to add the extra fields if it is a postback by the user after submitting or in edit mode
	if(isset($_POST['webquestLink']) && isset($_POST['activityNumber']) && $_POST['activityNumber'] != "")
		$dynamicinputfields = "../../../public/js/dynamicinputfields.php?clicks=" . count($_POST['webquestLink']);
	else
		$dynamicinputfields = "../../../public/js/dynamicinputfields.php";
	
	//END of GLOBAL VARIABLES PRESETS *****************************************************************************************************
	
	if(!empty($_POST['webquestSubmit'])) {
		
		//This hidden field will tell us how many questions are there and populate the array & set the false
		if(count($_POST['webquestLink']) > 1) { 
			for($i = 1; $i < count($_POST['webquestLink']); $i++) {
				$webquestLinkErrors1[$i] = false;
				$webquestTaskErrors1[$i] = false;
				$webquestTaskErrors2[$i] = false;
				$webquestQuestionErrors1[$i] = false;
				$webquestQuestionErrors2[$i] = false;
			}
		}		
		
		//Form validation
		$title = trim(filter_var($_POST['webquestTitle'], FILTER_SANITIZE_STRING));
		$description = trim(filter_var($_POST['webquestDescription'], FILTER_SANITIZE_STRING));
		$learningOutcomes = $_POST['webquestLearningOutcomes'];
		$overview = $_POST['webquestOverview'];
		
		$links = $_POST['webquestLink'];
		clearAndSetLinks($links); //clear the previous session if any before setting a new one
		foreach($links as $link) {
			$link = trim(filter_var($link, FILTER_SANITIZE_URL));
		}
		unset($link);
		
		$tasks = $_POST['webquestTask'];
		clearAndSetTasks($tasks); //clear the previous session if any before setting a new one
		foreach($tasks as $task) {
			$task = trim(filter_var($task, FILTER_SANITIZE_STRING));
		}
		unset($task);
		
		$questions = $_POST['webquestQuestion'];
		clearAndSetQuestions($questions);
		foreach($questions as $question) {
			$question = trim(filter_var($question, FILTER_SANITIZE_STRING));
		}
		unset($question);
		
		$evaluation = $_POST['webquestEvaluation'];
		
		if(strlen($title) == 0) { //if title is empty
			$webquestTitleError1 = true;
		}
		
		if(!preg_match("/^[a-z0-9- ]+$/i", $title)) { //if title have others characters beside a-z, 0-9, dash and space
			$webquestTitleError2 = true;
		}
		
		if(!isset($_POST['activityNumber'])) {
			if($webquest->checkForDuplicateTitle($title)) { //Check if there is duplicate title by SQL in database
				$webquestTitleError3 = true;	
			}
		}
		
		if(strlen($description) == 0) { //if description is empty
			$webquestDescriptionError1 = true;
		}
		
		if(!preg_match("/^[a-z0-9,.' ]+$/i", $description)) { //if description have other characters besides a-z, 0-9, comma, period and space
			$webquestDescriptionError2 = true;
    	}
    	
    	if($_FILES['webquestTitleImage']['size'] > 1500000) { //if image is more than 1.5 mb
    		$webquestImageError1 = true;
    	}
    	
    	$imageFileType = pathinfo($_FILES['webquestTitleImage']['name'], PATHINFO_EXTENSION);
    	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "") { //if image extention is jpg, png, jpeg or user choose not to use an image
    		$webquestImageError2 = true;
    	}
    	
    	if(strlen($learningOutcomes) == 0) { //if learning outcomes is empty
    		$webquestLearningOutcomeError1 = true;
    	}
    	
    	if(strlen($overview) == 0) { //if overview is empty
    		$webquestOverviewError1 = true;
    	}
    	
    	for($i = 0; $i < count($webquestLinkErrors1); $i++) { //if any of the links are empty
    		if(strlen($links[$i]) == 0) {
    			$webquestLinkErrors1[$i] = true;
    			$webquestOverallLinkError = true;
    		}
    	}
    	
    	for($i = 0; $i < count($webquestTaskErrors1); $i++) { //if any of the tasks are empty
    		if(strlen($tasks[$i]) == 0) {
    			$webquestTaskErrors1[$i] = true;
    			$webquestOverallTask1Error = true;
    		}
    		else {
    			for($j = 0; $j < count($webquestTaskErrors2); $j++) { //if any of the tasks have other characters besides a-z, 0-9, comma, peroid, single quote, ?, ! and space
    				if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $tasks[$j])) {
    					$webquestTaskErrors2[$j] = true;
    					$webquestOverallTask2Error = true;
    				}
    			}		
    		}
    	}
    	
    	for($i = 0; $i < count($webquestQuestionErrors1); $i++) { //if any of the questions are empty
    		if(strlen($questions[$i]) == 0) {
    			$webquestQuestionErrors1[$i] = true;
    			$webquestOverallQuestion1Error = true;
    		}
    		else {
    			for($j = 0; $j < count($webquestQuestionErrors2); $j++) { //if any of the questions have other characters besides a-z, 0-9, comma, peroid, single quote, ?, ! and space
    				if(!preg_match("/^[a-z0-9,.'?!\\n\r ]+$/i", $questions[$j])) {
    					$webquestQuestionErrors2[$j] = true;
    					$webquestOverallQuestion2Error = true;
    				}
    			}
    		}
    	}
    	
    	if(strlen($evaluation) == 0) {
    		$webquestEvaluationError1 = true;
    	}
    	
		//End of Form validation
		
		//No Validation required for these
		$color = $_POST['webquestThemeColor'];
		$image = $_FILES['webquestTitleImage']['name'] ? $_FILES['webquestTitleImage']['name'] : "";
		$imageTemp = $_FILES['webquestTitleImage']['tmp_name'] ? $_FILES['webquestTitleImage']['tmp_name'] : "";
				
		$publishMethod = $_POST['webquestPublishMethod'];
		$creativeCommon = $_POST['webquestCreativeCommon'];
		$allowCopy = isset($_POST['webquestAllowCopy']) ? $_POST['webquestAllowCopy'] : "no";
		
		//var_dump($_POST, $allowCopy, $image, $userInfoArray);

		if(!$webquestTitleError1 && !$webquestTitleError2 && !$webquestTitleError3 && !$webquestDescriptionError1 && !$webquestDescriptionError2 && !$webquestImageError1 && !$webquestImageError2 && !$webquestLearningOutcomeError1 && !$webquestOverviewError1 && !$webquestOverallLinkError && !$webquestOverallTask1Error && !$webquestOverallTask2Error && !$webquestOverallQuestion1Error && !$webquestOverallQuestion2Error && !$webquestEvaluationError1) {
			if($image != "") {
				$sessionImage = getImageName();
				
				if($sessionImage != "") {
					//delete the old file first
					$webquest->deleteUploadedFileFromBefore($sessionImage, $userInfoArray[1]);
				}

				$newImageName = $webquest->userUploadFile($image, $imageTemp, $userInfoArray[1]); //upload the image
			}
			else {
				$newImageName = "";
				
				if(empty($_POST['webquestTitleImageHidden'])) { //if the user removes image in edit mode, hidden field image value will be blank
					$sessionImage = getImageName();
					if(isset($_GET['activityNumber']) || isset($_POST['activityNumber']) && $sessionImage != "")
						$webquest->deleteUploadedFileFromBefore($sessionImage, $userInfoArray[1]); //delete the image from before and unset the $_SESSION image name
				}
				else {
					unsetImageSession();
					$newImageName = $_POST['webquestTitleImageHidden'];
				}
			}
			
			if(isset($_POST['activityNumber']) && $_POST['activityNumber'] != "") { //edit mode operations
				$webquest->editWebQuestActivityToDatabase($_POST['activityNumber'], $title, $description, $newImageName, $color, $learningOutcomes, $overview, $links, $tasks, $questions, $evaluation, $publishMethod, $creativeCommon, $allowCopy, $userInfoArray[0]);
			}
			else { //new activity created operations
				$webquest->insertWebquestActivityToDatabase($title, $description, $newImageName, $color, $learningOutcomes, $overview, $links, $tasks, $questions, $evaluation, $publishMethod, $creativeCommon, $allowCopy, $userInfoArray[0]);
			}
			
			header("Location: ../activityMain/activity.php?submit=yes");
			exit;
		}
		
	} //if(!empty($_POST))
?>
