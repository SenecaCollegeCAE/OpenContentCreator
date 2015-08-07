<?php
	require_once("../../../resources/models/Trivia.php"); //call the trivia model class, it also call the parent activity model class
	$trivia = new Trivia();
	
	require_once("./triviaSessions.php"); //clear the previous sessions of submits if any before setting a new one
		
	//Edit mode presets *************************************************************************************************
	if(isset($_GET['activityNumber']) && isset($activityObj)) {
		$_POST['activityNumber'] = $activityObj[0];
		
		//check if activity belongs to you before you can edit it, otherwise redirect back to main page
		if(isset($_POST['activityNumber']) && $_POST['activityNumber'] != "") {
			if(!$trivia->checkIfActivityIsYours($userInfoArray[0], $_POST['activityNumber'])) { //returns true or false
				header("Location: ../activityMain/activity.php");
				exit;	
			}
			else { //activity belongs to you, populate the $_POST fields with you info
				$trivia->setTriviaActivityForEdit($activityObj); //set the trivia class obj with the edit info and set the $_POST info as well
				$_POST['triviaTitle'] = $activityObj[1];
				$_POST['triviaDescription'] = $activityObj[2];
				$_POST['triviaTitleImage'] = $activityObj[3];
				setImageName($_POST['triviaTitleImage']);
				$_POST['triviaThemeColor'] = $activityObj[4];
				$_POST['triviaPointStyle'] = $activityObj[5];
				$_POST['triviaLifeline5050'] = $activityObj[6];
				$_POST['triviaLifelineHint'] = $activityObj[7];
				$_POST['triviaLifelineAudience'] = $activityObj[8];
				$difficulties = $_POST['triviaDifficulty'] = $activityObj[9];
				$questions = $_POST['triviaQuestion'] = $activityObj[10];
				$correctAnswers = $_POST['triviaCorrectAnswer'] = $activityObj[11];
				$wrongAnswers1 = $_POST['triviaWrongAnswer1'] = $activityObj[12];
				$wrongAnswers2 = $_POST['triviaWrongAnswer2'] = $activityObj[13];
				$wrongAnswers3 = $_POST['triviaWrongAnswer3'] = $activityObj[14];
				$hints = $_POST['triviaHint'] = $activityObj[15];
				$_POST['triviaPublishMethod'] = $activityObj[16];
				$_POST['triviaCreativeCommon'] = $activityObj[17];
				$_POST['triviaAllowCopy'] = $activityObj[18];
			}
		}
	}
	//End of edit mode presets *************************************************************************************************
	
	//Global variables to tell if there are errors, and set other flags for other things *****************************************************************************************************
	$triviaTitleError1 = $triviaTitleError2 = $triviaTitleError3 = false;
	$triviaDescriptionError1 = $triviaDescriptionError2 = false;
	$triviaImageError1 = $triviaImageError2 = false;
	
	$triviaQuestionError1 = [];
	$triviaQuestionError1[0] = $triviaQuestionError1[1] = $triviaQuestionError1[2] = $triviaQuestionError1[3] = $triviaQuestionError1[4] = false;
	$triviaOverallQuestionError1 = false; //instead of looping and checking all 5
	$triviaQuestionError2 = [];
	$triviaQuestionError2[0] = $triviaQuestionError2[1] = $triviaQuestionError2[2] = $triviaQuestionError2[3] = $triviaQuestionError2[4] = $triviaQuestionError2[5] = $triviaQuestionError2[6] = $triviaQuestionError2[7] = $triviaQuestionError2[8] = $triviaQuestionError2[9] = $triviaQuestionError2[10] = $triviaQuestionError2[11] = false;
	$triviaOverallQuestionError2 = false; //instead of looping and checking all 12
	
	$triviaCorrectAnswerError1 = [];
	$triviaCorrectAnswerError1[0] = $triviaCorrectAnswerError1[1] = $triviaCorrectAnswerError1[2] = $triviaCorrectAnswerError1[3] = $triviaCorrectAnswerError1[4] = false;
	$triviaOverallCorrectAnswerError1 = false; 
	$triviaCorrectAnswerError2 = [];
	$triviaCorrectAnswerError2[0] = $triviaCorrectAnswerError2[1] = $triviaCorrectAnswerError2[2] = $triviaCorrectAnswerError2[3] = $triviaCorrectAnswerError2[4] = $triviaCorrectAnswerError2[5] = $triviaCorrectAnswerError2[6] = $triviaCorrectAnswerError2[7] = $triviaCorrectAnswerError2[8] = $triviaCorrectAnswerError2[9] = $triviaCorrectAnswerError2[10] = $triviaCorrectAnswerError2[11] = false;
	$triviaOverallCorrectAnswerError2 = false; 
	
	$triviaWrongAnswer1Error1 = [];
	$triviaWrongAnswer1Error1[0] = $triviaWrongAnswer1Error1[1] = $triviaWrongAnswer1Error1[2] = $triviaWrongAnswer1Error1[3] = $triviaWrongAnswer1Error1[4] = false;
	$triviaOverallWrongAnswer1Error1 = false;
	$triviaWrongAnswer1Error2 = [];
	$triviaWrongAnswer1Error2[0] = $triviaWrongAnswer1Error2[1] = $triviaWrongAnswer1Error2[2] = $triviaWrongAnswer1Error2[3] = $triviaWrongAnswer1Error2[4] = $triviaWrongAnswer1Error2[5] = $triviaWrongAnswer1Error2[6] = $triviaWrongAnswer1Error2[7] = $triviaWrongAnswer1Error2[8] = $triviaWrongAnswer1Error2[9] = $triviaWrongAnswer1Error2[10] = $triviaWrongAnswer1Error2[11] = false;
	$triviaOverallWrongAnswer1Error2 = false;
	
	$triviaWrongAnswer2Error1 = [];
	$triviaWrongAnswer2Error1[0] = $triviaWrongAnswer2Error1[1] = $triviaWrongAnswer2Error1[2] = $triviaWrongAnswer2Error1[3] = $triviaWrongAnswer2Error1[4] = false;
	$triviaOverallWrongAnswer2Error1 = false;
	$triviaWrongAnswer2Error2 = [];
	$triviaWrongAnswer2Error2[0] = $triviaWrongAnswer2Error2[1] = $triviaWrongAnswer2Error2[2] = $triviaWrongAnswer2Error2[3] = $triviaWrongAnswer2Error2[4] = $triviaWrongAnswer2Error2[5] = $triviaWrongAnswer2Error2[6] = $triviaWrongAnswer2Error2[7] = $triviaWrongAnswer2Error2[8] = $triviaWrongAnswer2Error2[9] = $triviaWrongAnswer2Error2[10] = $triviaWrongAnswer2Error2[11] = false;
	$triviaOverallWrongAnswer2Error2 = false;
	
	$triviaWrongAnswer3Error1 = [];
	$triviaWrongAnswer3Error1[0] = $triviaWrongAnswer3Error1[1] = $triviaWrongAnswer3Error1[2] = $triviaWrongAnswer3Error1[3] = $triviaWrongAnswer3Error1[4] = false;
	$triviaOverallWrongAnswer3Error1 = false;
	$triviaWrongAnswer3Error2 = [];
	$triviaWrongAnswer3Error2[0] = $triviaWrongAnswer3Error2[1] = $triviaWrongAnswer3Error2[2] = $triviaWrongAnswer3Error2[3] = $triviaWrongAnswer3Error2[4] = $triviaWrongAnswer3Error2[5] = $triviaWrongAnswer3Error2[6] = $triviaWrongAnswer3Error2[7] = $triviaWrongAnswer3Error2[8] = $triviaWrongAnswer3Error2[9] = $triviaWrongAnswer3Error2[10] = $triviaWrongAnswer3Error2[11] = false;
	$triviaOverallWrongAnswer3Error2 = false;
	
	$triviaHintError1 = [];
	$triviaHintError1[0] = $triviaHintError1[1] = $triviaHintError1[2] = $triviaHintError1[3] = $triviaHintError1[4] = $triviaHintError1[5] = $triviaHintError1[6] = $triviaHintError1[7] = $triviaHintError1[8] = $triviaHintError1[9] = $triviaHintError1[10] = $triviaHintError1[11] = false;
	$triviaOverallHintError1 = false;
	
	$dynamicinputfields = "../../../public/js/dynamictriviafields.js";
	
	//END of GLOBAL VARIABLES PRESETS *****************************************************************************************************
	
	if(!empty($_POST['triviaSubmit'])) {
				
		//Form validation
		$title = trim(filter_var($_POST['triviaTitle'], FILTER_SANITIZE_STRING));
		$description = trim(filter_var($_POST['triviaDescription'], FILTER_SANITIZE_STRING));
		
		if(strlen($title) == 0) { //if title is empty
			$triviaTitleError1 = true;
		}
		
		if(!preg_match("/^[a-z0-9- ]+$/i", $title)) { //if title have others characters beside a-z, 0-9, dash and space
			$triviaTitleError2 = true;	
		}
		
		if(!isset($_POST['activityNumber'])) {
			if($trivia->checkForDuplicateTitle($title)) { //Check if there is duplicate title by SQL in database
				$triviaTitleError3 = true;
			}
		}
		
		if(strlen($description) == 0) { //if description is empty
			$triviaDescriptionError1 = true;
		}
		
		if(!preg_match("/^[a-z0-9,.' ]+$/i", $description)) { //if description have other characters besides a-z, 0-9, comma, period and space
			$triviaDescriptionError2 = true;
		}
		
		if($_FILES['triviaTitleImage']['size'] > 1500000) { //if image is more than 1.5 mb
    		$triviaImageError1 = true;
		}

		$imageFileType = pathinfo($_FILES['triviaTitleImage']['name'], PATHINFO_EXTENSION);
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "") { //if image extention is jpg, png, jpeg or user choose not to use an image
			$triviaImageError2 = true;
		}
		
		$questions = $_POST['triviaQuestion'];
		for($i = 0; $i < 5; $i++) { //if any of the questions are empty
			if(isset($questions[$i])) {
				if(strlen($questions[$i]) == 0) {
					$triviaQuestionError1[$i] = true;
					$triviaOverallQuestionError1 = true;
				}
				else {
					if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $questions[$i])) {
						$triviaQuestionError2[$i] = true;
						$triviaOverallQuestionError2 = true;
					}
				}
			}
		}

		for($j = 5; $j < count($triviaQuestionError2); $j++) { //if any of the questions have other characters besides a-z, 0-9, comma, peroid, single quote, ?, ! and space
				if(!empty($questions[$j])) {
					if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $questions[$j])) {
						$triviaQuestionError2[$j] = true;
						$triviaOverallQuestionError2 = true;
					}
				}
			}
		
		$correctAnswers = $_POST['triviaCorrectAnswer'];
		for($i = 0; $i < 5; $i++) { //if any of the correct answers are empty
			if(isset($correctAnswers[$i])) {
				if(strlen($correctAnswers[$i]) == 0) {
					$triviaCorrectAnswerError1[$i] = true;
					$triviaOverallCorrectAnswerError1 = true;
				}
				else {
					if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $correctAnswers[$i])) {
						$triviaCorrectAnswerError2[$i] = true;
						$triviaOverallCorrectAnswerError2 = true;
					}
				}
			}
		}
		
		for($j = 5; $j < count($triviaCorrectAnswerError2); $j++) { //if any of the correct answers have other characters besides a-z, 0-9, comma, peroid, single quote, ?, ! and space
			if(!empty($correctAnswers[$j])) {
				if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $correctAnswers[$j])) {
					$triviaCorrectAnswerError2[$j] = true;
					$triviaOverallCorrectAnswerError2 = true;
				}
			}
		}
			
		$wrongAnswers1 = $_POST['triviaWrongAnswer1'];
		for($i = 0; $i < 5; $i++) { //if any of the wrong answers 1 are empty
			if(isset($wrongAnswers1[$i])) {
				if(strlen($wrongAnswers1[$i]) == 0) {
					$triviaWrongAnswer1Error1[$i] = true;
					$triviaOverallWrongAnswer1Error1 = true;
				}
				else {
					if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $wrongAnswers1[$i])) {
						$triviaWrongAnswer1Error2[$i] = true;
						$triviaOverallWrongAnswer1Error2 = true;
					}
				}
			}
		}
		
		for($j = 5; $j < count($triviaWrongAnswer1Error2); $j++) { //if any of the wrong answers 1 have other characters besides a-z, 0-9, comma, peroid, single quote, ?, ! and space
			if(!empty($wrongAnswers1[$j])) {
				if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $wrongAnswers1[$j])) {
					$triviaWrongAnswer1Error2[$j] = true;
					$triviaOverallWrongAnswer1Error2 = true;
				}
			}
		}
		
		
		$wrongAnswers2 = $_POST['triviaWrongAnswer2'];
		for($i = 0; $i < 5; $i++) { //if any of the wrong answers 2 are empty
			if(isset($wrongAnswers2[$i])) {
				if(strlen($wrongAnswers2[$i]) == 0) {
					$triviaWrongAnswer2Error1[$i] = true;
					$triviaOverallWrongAnswer2Error1 = true;
				}
				else {
					if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $wrongAnswers2[$i])) {
						$triviaWrongAnswer2Error2[$i] = true;
						$triviaOverallWrongAnswer2Error2 = true;
					}
				}
			}
		}
		
		for($j = 5; $j < count($triviaWrongAnswer2Error2); $j++) { //if any of the wrong answers 2 have other characters besides a-z, 0-9, comma, peroid, single quote, ?, ! and space
			if(!empty($wrongAnswers2[$j])) {
				if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $wrongAnswers2[$j])) {
					$triviaWrongAnswer2Error2[$j] = true;
					$triviaOverallWrongAnswer2Error2 = true;
				}
			}
		}
		
		$wrongAnswers3 = $_POST['triviaWrongAnswer3'];
		for($i = 0; $i < 5; $i++) { //if any of the wrong answers 2 are empty
			if(isset($wrongAnswers3[$i])) {
				if(strlen($wrongAnswers3[$i]) == 0) {
					$triviaWrongAnswer3Error1[$i] = true;
					$triviaOverallWrongAnswer3Error1 = true;
				}
				else {
					if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $wrongAnswers3[$i])) {
						$triviaWrongAnswer3Error2[$i] = true;
						$triviaOverallWrongAnswer3Error2 = true;
					}
				}
			}
		}	
		
		for($j = 5; $j < count($triviaWrongAnswer3Error2); $j++) { //if any of the wrong answers 2 have other characters besides a-z, 0-9, comma, peroid, single quote, ?, ! and space
			if(!empty($wrongAnswers3[$j])) {
				if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $wrongAnswers3[$j])) {
					$triviaWrongAnswer3Error2[$j] = true;
					$triviaOverallWrongAnswer3Error2 = true;
				}
			}
		}
		
		$hints = $_POST['triviaHint'];
		for($i = 0; $i < count($hints); $i++) { //if any of the wrong answers 2 have other characters besides a-z, 0-9, comma, peroid, single quote, ?, ! and space
			if(!empty($hints[$i])) {
				if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $hints[$i])) {
					$triviaHintError1[$i] = true;
					$triviaOverallHintError1 = true;
				}
			}
		}
		
		//End of Form validation
		
		//No Validation required for these
		$color = $_POST['triviaThemeColor'];
		$image = $_FILES['triviaTitleImage']['name'] ? $_FILES['triviaTitleImage']['name'] : "";
		$imageTemp = $_FILES['triviaTitleImage']['tmp_name'] ? $_FILES['triviaTitleImage']['tmp_name'] : "";
		
		$pointStyle = $_POST['triviaPointStyle'];
		$lifeLine5050 = $_POST['triviaLifeline5050'];
		$lifeLineHint = $_POST['triviaLifelineHint'];
		$lifeLineAudience = $_POST['triviaLifelineAudience'];
		$difficulty = $_POST['triviaDifficulty'];
		
		$publishMethod = $_POST['triviaPublishMethod'];
		$creativeCommon = $_POST['triviaCreativeCommon'];
		$allowCopy = isset($_POST['triviaAllowCopy']) ? $_POST['triviaAllowCopy'] : "no";
		
		//var_dump($_POST, $allowCopy, $image, $userInfoArray);
		
		if(!$triviaTitleError1 && !$triviaTitleError2 && !$triviaTitleError3 && !$triviaDescriptionError1 && !$triviaDescriptionError2 && !$triviaImageError1 && !$triviaImageError2 && !$triviaOverallQuestionError1 && !$triviaOverallQuestionError2 && !$triviaOverallCorrectAnswerError1 && !$triviaOverallCorrectAnswerError2 && !$triviaOverallWrongAnswer1Error1 && !$triviaOverallWrongAnswer1Error2 && !$triviaOverallWrongAnswer2Error1 && !$triviaOverallWrongAnswer2Error2 && !$triviaOverallWrongAnswer3Error1 && !$triviaOverallWrongAnswer3Error2 && !$triviaOverallHintError1) {		
			if($image != "") {
				$sessionImage = getImageName();
				
				if($sessionImage != "") {
					//delete the old file first
					$trivia->deleteUploadedFileFromBefore($sessionImage, $userInfoArray[1]);
				}
					
				$newImageName = $trivia->userUploadFile($image, $imageTemp, $userInfoArray[1]); //upload the image
			}
			else {
				$newImageName = "";
				
				 if(empty($_POST['triviaTitleImageHidden'])) { //if the user removes image in edit mode, hidden field image value will be blank
				 	$sessionImage = getImageName();
				 	if(isset($_GET['activityNumber']) || isset($_POST['activityNumber']) && $sessionImage != "")
				 		$trivia->deleteUploadedFileFromBefore($sessionImage, $userInfoArray[1]); //delete the image from before and unset the $_SESSION image name
				 }
				 else {
				 	unsetImageSession();
				 	$newImageName = $_POST['triviaTitleImageHidden'];
				 }
			}
			
			if(isset($_POST['activityNumber']) && $_POST['activityNumber'] != "") { //edit mode operations
				$trivia->editTriviaActivityToDatabase($_POST['activityNumber'], $title, $description, $newImageName, $color, $pointStyle, $lifeLine5050, $lifeLineHint, $lifeLineAudience, $difficulty, $questions, $correctAnswers, $wrongAnswers1, $wrongAnswers2, $wrongAnswers3, $hints, $publishMethod, $creativeCommon, $allowCopy, $userInfoArray[0]);
			}
			else { //new activity created operations
				$trivia->insertTriviaActivityToDatabase($title, $description, $newImageName, $color, $pointStyle, $lifeLine5050, $lifeLineHint, $lifeLineAudience, $difficulty, $questions, $correctAnswers, $wrongAnswers1, $wrongAnswers2, $wrongAnswers3, $hints, $publishMethod, $creativeCommon, $allowCopy, $userInfoArray[0]);
			}
			
			header("Location: ../activityMain/activity.php?submit=yes");
			exit;
			
		}
		
	} //if(!empty($_POST))
?>
