<?php
	require_once("../../../resources/models/Label.php"); //call the label model class, it also call the parent activity model class
	$label = new Label();
	
	require_once("./labelSessions.php"); //clear the previous sessions of submits if any before setting a new one
	
	if(empty($_POST['labelSubmit']))
		$label->deleteAllTemporaryFiles("TEMP", $userInfoArray[1]); //This should only delete the TEMP picture file when it is the first time going to the form. Shouldn't delete during postbacks
	//require_once("./labelSessions.php");
	
	//Edit mode presets *************************************************************************************************
	if(isset($_GET['activityNumber']) && isset($activityObj)) {
		$_POST['activityNumber'] = $activityObj[0];
		
		//check if activity belongs to you before you can edit it, otherwise redirect back to main page
		if(isset($_POST['activityNumber']) && $_POST['activityNumber'] != "") {
			if(!$label->checkIfActivityIsYours($userInfoArray[0], $_POST['activityNumber'])) { //returns trure of false
				header("Location: ../activityMain/activity.php");
				exit;
			}
			else { //activity belongs to you, populate the $_POST fields with your info
				$label->setLabelActivityForEdit($activityObj); //set the label class obj with the edit info and set the $_POST info as well
				$_POST['labelTitle'] = $activityObj[1];
				$_POST['labelDescription'] = $activityObj[2];
				$_POST['labelTitleImage'] = $activityObj[3];
				setImageName($_POST['labelTitleImage']);
				$_POST['labelThemeColor'] = $activityObj[4];
				$_POST['labelActivityImage'] = $activityObj[5];
				$_POST['labelCurrentLabel'] = $activityObj[7];
				$_POST['labelNumOfTimesCreateWasClicked'] = $activityObj[8];
				$_POST['labelLabelArray'] = json_encode($activityObj[6]);
				$_POST['labelCoordsArray'] = json_encode($activityObj[9]);
				$_POST['labelImageTarget'] = $label->renameFileForHiddenLabelImageTarget($activityObj[5], $userInfoArray[1]);
				$_POST['labelPostback'] = 1; //Set it to 1 because it is in edit mode
				//var_dump($_POST);
			}
		}
		
	}
	//End of edit mode presets *************************************************************************************************
	
	//Global variables to tell if there are errors, and set other flags for other things *****************************************************************************************************
	$labelTitleError1 = $labelTitleError2 = $labelTitleError3 = false;
	$labelDescriptionError1 = $labelDescriptionError2 = false;
	$labelImageError1 = $labelImageError2 = false;
	
	$labelActivityImageError1 = $labelActivityImageError2 = $labelActivityImageError3 = false;
	$labelLabels = []; //Array used to store label element values
	$labelLabelError1 = [];
	$labelLabelError2 = [];
	$labelLabelError1[0] = $labelLabelError1[1] = $labelLabelError1[2] = $labelLabelError1[3] = $labelLabelError1[4] = $labelLabelError1[5] = $labelLabelError1[6] = $labelLabelError1[7] = $labelLabelError1[8] = false;
	$labelLabelError2[0] = $labelLabelError2[1] = $labelLabelError2[2] = $labelLabelError2[3] = $labelLabelError2[4] = $labelLabelError2[5] = $labelLabelError2[6] = $labelLabelError2[7] = $labelLabelError2[8] = false;
	//END of GLOBAL VARIABLES PRESETS *****************************************************************************************************
	
	if(!empty($_POST['labelSubmit'])) {		
		
		//Form validation
		$title = trim(filter_var($_POST['labelTitle'], FILTER_SANITIZE_STRING));
		$description = trim(filter_var($_POST['labelDescription'], FILTER_SANITIZE_STRING));
		
		if(strlen($title) == 0) { //if title is empty
			$labelTitleError1 = true;
		}
		
		if(!preg_match("/^[a-z0-9- ]+$/i", $title)) { //if title have others characters beside a-z, 0-9, dash and space
			$labelTitleError2 = true;
		}
		
		if(!isset($_POST['activityNumber'])) {
			if($label->checkForDuplicateTitle($title)) { //Check if there is duplicate title by SQL in database
				$labelTitleError3 = true;
			}
		}
		
		if(strlen($description) == 0) {
			$labelDescriptionError1 = true;
		}
		
		if(!preg_match("/^[a-z0-9,.' ]+$/i", $description)) { //if description have other characters besides a-z, 0-9, comma, period and space
			$labelDescriptionError2 = true;
		}
		
		if($_FILES['labelTitleImage']['size'] > 1500000) { //if image is more than 1.5 mb
			$labelImageError1 = true;
		}
		
		$imageFileType = pathinfo($_FILES['labelTitleImage']['name'], PATHINFO_EXTENSION);
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "") { //if image extention is jpg, png, jpeg or user choose not to use an image
			$labelImageError2 = true;
		}
		
		//Submit the activity image as temporary so it will display incase of form errors
		$activityImage = isset($_FILES['labelActivityImage']['name']) ? $_FILES['labelActivityImage']['name'] : "";
		$activityImageTemp = isset($_FILES['labelActivityImage']['tmp_name']) ? $_FILES['labelActivityImage']['tmp_name'] : "";
		
		if($activityImage == "") { //if activity image is empty
			if(!isset($_POST['labelActivityImageHidden'])) {
				$labelActivityImageError1 = true;
			}
			else {
				$activityImage = $_POST['labelActivityImageHidden']; //$label->removeTimeStampFromImage($_POST['labelActivityImageHidden']);
			}			
		}
		else {
			if($_FILES['labelActivityImage']['size'] > 1500000) { //if image is more than 1.5 mb
				$labelActivityImageError2 = true;
			}
			else {
				$activityImageFileType = pathinfo($_FILES['labelActivityImage']['name'], PATHINFO_EXTENSION);
				
				if($activityImageFileType != "jpg" && $activityImageFileType != "png" && $activityImageFileType != "jpeg" && $activityImageFileType != "") { //if image extention is jpg, png, jpeg or user choose not to use an image
					$labelActivityImageError3 = true;	
				}
				else {
					$_POST['labelImageTarget'] = $label->temporarySubmittedActivityImage($activityImage, $activityImageTemp, $userInfoArray[1]); //save the image temporary
				}
			}
		}
		
		array_push($labelLabels, $_POST['labelLabel1']);
		
		if(isset($_POST['labelLabel2'])) { array_push($labelLabels, $_POST['labelLabel2']); }	
		if(isset($_POST['labelLabel3'])) { array_push($labelLabels, $_POST['labelLabel3']); }	
		if(isset($_POST['labelLabel4'])) { array_push($labelLabels, $_POST['labelLabel4']); }		
		if(isset($_POST['labelLabel5'])) { array_push($labelLabels, $_POST['labelLabel5']); }		
		if(isset($_POST['labelLabel6'])) { array_push($labelLabels, $_POST['labelLabel6']); }		
		if(isset($_POST['labelLabel7'])) { array_push($labelLabels, $_POST['labelLabel7']); }		
		if(isset($_POST['labelLabel8'])) { array_push($labelLabels, $_POST['labelLabel8']); }		
		if(isset($_POST['labelLabel9'])) { array_push($labelLabels, $_POST['labelLabel9']); }
		
		for($i = 0; $i < count($labelLabels); $i++) {
			if(isset($labelLabels[$i])) {
				if(strlen($labelLabels[$i]) == 0) {
					$labelLabelError1[$i] = true;
				}
				else {
					if(!preg_match("/^[a-z0-9,.'?!\n\r ]+$/i", $labelLabels[$i])) {
						$labelLabelError2[$i] = true;
					}
				}
			}	
		}
		
		//End of Form validation
		
		//No Validation required for these
		$color = $_POST['labelThemeColor'];
		$image = isset($_FILES['labelTitleImage']['name']) ? $_FILES['labelTitleImage']['name'] : "";
		$imageTemp = isset($_FILES['labelTitleImage']['tmp_name']) ? $_FILES['labelTitleImage']['tmp_name'] : "";
		
		$publishMethod = $_POST['labelPublishMethod'];
		$creativeCommon = $_POST['labelCreativeCommon'];
		$allowCopy = isset($_POST['labelAllowCopy']) ? $_POST['labelAllowCopy'] : "no";
		
		//var_dump($_POST, $labelLabels);
		
		if(!$labelTitleError1 && !$labelTitleError2 && !$labelTitleError3 && !$labelDescriptionError1 && !$labelDescriptionError2 && !$labelImageError1 && !$labelImageError2 && !$labelActivityImageError1 && !$labelActivityImageError2 && !$labelActivityImageError3) {
			$allLabelElementsThatAreWrong = false;
			
			for($i = 0; $i < count($labelLabels); $i++) {
				if(isset($labelLabels[$i])) {
					if(!$labelLabelError1[$i] && !$labelLabelError2[$i])
						$allLabelElementsThatAreWrong = false;
					else 
						$allLabelElementsThatAreWrong = true;
				}
			}
			
			if(!$allLabelElementsThatAreWrong) {
				if($image != "") {
					$sessionImage = getImageName();
					
					if($sessionImage != "") {
						//delete the old file first if the images are differnt from last time (Meaning the user decices to change the title image or not use it)
						if(strcmp($sessionImage, $_POST['labelTitleImage']) != 0)
							$label->deleteUploadedFileFromBefore($sessionImage, $userInfoArray[1]);
					}
					
					$newImageName = $label->userUploadFile($image, $imageTemp, $userInfoArray[1]);
				}
				else {
					$newImageName = "";
					
					if(empty($_POST['labelTitleImageHidden'])) { //if the user removes image in edit mode, hidden field image value will be blank
						$sessionImage = getImageName();
						if(isset($_GET['activityNumber']) || isset($_POST['activityNumber']) && $sessionImage != "") {
							if(strcmp($sessionImage, $_POST['labelTitleImage']) != 0)
								$label->deleteUploadedFileFromBefore($sessionImage, $userInfoArray[1]); //delete the image from before and unset the $_SESSION image name
						}
					}
					else {
						unsetImageSession();
						$newImageName = $_POST['labelTitleImageHidden'];
					}
				}
				
				$activityImageLocation = $_POST['labelImageTarget'];
				
				$newActivityImageName = $label->addTimestampToActivityImage($activityImageLocation, $activityImage, $activityObj[5], $userInfoArray[1]);
				$numberOfTimesCreateWasClicked = $_POST['labelNumOfTimesCreateWasClicked'];
				$activityImageCoordinates = json_decode(stripslashes($_POST['labelCoordsArray']));
				
				if(isset($_POST['activityNumber']) && $_POST['activityNumber'] != "") { //edit mode operations
					$label->editLabelActivityToDatabase($_POST['activityNumber'], $title, $description, $newImageName, $color, $newActivityImageName, $labelLabels, $numberOfTimesCreateWasClicked, $activityImageCoordinates, $publishMethod, $creativeCommon, $allowCopy, $userInfoArray[0]);
				}
				else {
					$label->insertLabelActivityToDatabase($title, $description, $newImageName, $color, $newActivityImageName, $labelLabels, $numberOfTimesCreateWasClicked, $activityImageCoordinates, $publishMethod, $creativeCommon, $allowCopy, $userInfoArray[0]);
				}
				
				header("Location: ../activityMain/activity.php?submit=yes");
				exit;
			}
		}
	}
?>