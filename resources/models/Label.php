<?php
	require_once("Activity.php");
	
	class Label extends Activity{
		private $_activityImage; //use for hidden labelImageTarget
		private $_labels; //Max of 9 labels //used for hidden labeLabelArray
		private $_currentLabel;
		private $_numOfTimesCreateWasClicked;
		private $_coordinates; //used for hidden labelCoordsArray
		
		function __construct() {
			$this->_labels = [];
			$this->_coordinates = [];
		}
		
		private function removeTimeStampFromImage($activityFileHidden) {
			$tempArrayExploded = explode("/", $activityFileHidden);
			$tempString = explode(".", $tempArrayExploded[7]);
			$extension = end($tempString);
			$pictureName = reset($tempString);
				
			$finalFilename = substr($pictureName, 0, 6) .  "." . $extension;
			return $finalFilename;
		} //private function removeTimeStampFromImage
		
		//This temporary submits and save the working image to the user's image folder. Used for postbacks, incase there are form errors, you still want to display the working image
		public function temporarySubmittedActivityImage($file, $fileTemp, $userName) { 
			$targetDirectory = "../../../public/img/users/" . $userName ."/";
			$tempString = explode(".", $file);
			$extension = end($tempString);
			$pictureName = reset($tempString);
			
			$this->_activityImage = $targetDirectory . "TEMP" . basename($pictureName) . "." . $extension;
			
			move_uploaded_file($fileTemp, $this->_activityImage); 
			
			return $this->_activityImage;
		} //function temporarySubmittedActivityImage
		
		public function deleteAllTemporaryFiles($stringExp, $userName) {
			$targetDirectory = "../../../public/img/users/" . $userName ."/";
			$images = glob($targetDirectory . "TEMP*");
						
			foreach($images as $image) {
				unlink($image);
			}
			
		} //function deleteAllTemporaryFiles
		
		public function addTimestampToActivityImage($activityImageLocation, $activityFile, $originalActivityFile, $userName) {			
			$newNameActivityFile = $activityFile;
			$test = explode("/", $activityFile);
			
			if(isset($test[7])) { $newNameActivityFile = $this->removeTimeStampFromImage($activityFile); } //this if this file is from edit mode so it a full relative link with ../../something ...etc
			
			$targetDirectory = "../../../public/img/users/" . $userName . "/";
			$tempString = explode(".", $newNameActivityFile);
			$extension = end($tempString);
			$pictureName = reset($tempString);
			$filenameAddon = substr(uniqid(mt_rand(), true), 0, 7); //generates a random string with 7 digits
			
			$this->_activityImage = $targetDirectory . basename($pictureName) . $filenameAddon . "." . $extension;			
			rename($activityImageLocation, $this->_activityImage);
						
			if($activityFile != $originalActivityFile) { unlink($originalActivityFile); } //Test if images are the same, if not delete the original because we don't need to use the old image anymore. 
			
			if(isset($test[7])) { unlink($activityFile); } //Delete original file if user decides to use the same image for the activity. (We just copying the original file to make a new one, rename that new file and delete the old one)
			
			return $this->_activityImage;
		} //function addTimestampToActivityImage
		
		public function renameFileForHiddenLabelImageTarget($serverFileName, $userName) {
			$targetDirectory = "../../../public/img/users/" . $userName . "/";
			$fileNameString = substr($serverFileName, strrpos($serverFileName, '/') + 1); //get the file name only of the string
			$tempString = $targetDirectory . "TEMP" . $fileNameString;
			
			copy($serverFileName, $tempString);
					
			return $tempString;
		} //function renameFileForHiddenLabelImageTarget
		
		public function insertLabelActivityToDatabase($title, $description, $image, $color, $activityImage, $labelElements, $clickNumber, $coordinates, $publishMethod, $creativeCommon, $allowCopy, $userId) {
			require("../../../resources/connect.inc.php");
			
			$this->_title = $title;
			$this->_description = $description;
			$this->_titleImage = $image;
			$this->_themeColor = $color;
			$this->_activityImage = $activityImage;
			$this->_labels = $labelElements;
			$this->_numOfTimesCreateWasClicked = $clickNumber;
			$this->_coordinates = $coordinates;
			$this->_publishMethod = $publishMethod;
			$this->_creativeCommons = $creativeCommon;
			$this->_copyActivity = $allowCopy;
			$this->_creatorId = $userId;
			$this->_time = date("Y-m-d h:i:s");
			$this->_activityType = 'label';
			$this->_copied = 'no';
			
			$result = $dbh->prepare("INSERT INTO activities VALUES(:activityId, :userId, :title, :type, :publishMethod, :creativeCommon, :allowCopy, :time, :copied)");
			$result->execute(array(
					'activityId' => '',
					'userId' => $this->_creatorId,
					'title' => $this->_title,
					'type' => $this->_activityType,
					'publishMethod' => $this->_publishMethod,
					'creativeCommon' => $this->_creativeCommons,
					'allowCopy' => $this->_copyActivity,
					'time' => $this->_time,
					'copied' => $this->_copied
			));
			
			//need to get the activityId generated and use it for the trivia here
			$selectResult = $dbh->prepare("SELECT activity_id FROM activities WHERE activity_creator = :userId AND activity_title = :title");
			$selectResult->execute(array('userId' => $this->_creatorId, 'title' => $this->_title));
				
			while($selectResultRow = $selectResult->fetch(PDO::FETCH_ASSOC)) {
				$this->_activityId = $selectResultRow['activity_id'];
			}
			
			//serialize the label elements, and coordinates
			$result2 = $dbh->prepare("INSERT INTO label_activities VALUES(:labelId, :title, :description, :image, :color, :activityImage, :labels, :clicks, :coordinates)");
			$result2->execute(array(
					'labelId' => $this->_activityId,
					'title' => $this->_title,
					'description' => $this->_description,
					'image' => $this->_titleImage,
					'color' => $this->_themeColor,
					'activityImage' => $this->_activityImage,
					'labels' => base64_encode(serialize($this->_labels)),
					'clicks' => $this->_numOfTimesCreateWasClicked,
					'coordinates' => base64_encode(serialize($this->_coordinates))
			));
			
			$dbh = null;
			
		} //function insertLabelActivityToDatabase
		
		public function editLabelActivityToDatabase($activityId, $title, $description, $image, $color, $activityImage, $labelElements, $clickNumber, $coordinates, $publishMethod, $creativeCommon, $allowCopy, $userId) {
			require("../../../resources/connect.inc.php");
			
			$this->_activityId = $activityId;
			$this->_title = $title;
			$this->_description = $description;
			$this->_titleImage = $image;
			$this->_themeColor = $color;
			$this->_activityImage = $activityImage;
			$this->_labels = $labelElements;
			$this->_numOfTimesCreateWasClicked = $clickNumber;
			$this->_coordinates = $coordinates;
			$this->_publishMethod = $publishMethod;
			$this->_creativeCommons = $creativeCommon;
			$this->_copyActivity = $allowCopy;
			$this->_creatorId = $userId;
			$this->_time = date("Y-m-d h:i:s");
			$this->_activityType = 'label';
			
			$result = $dbh->prepare("UPDATE activities SET activity_title = :title, activity_publish_method = :publishMethod, activity_creative_common = :creativeCommon, activity_allow_copy = :allowCopy, activity_time = :time WHERE activity_id = :activityId AND activity_creator = :activityCreator");
			$result->execute(array(
					'title' => $this->_title,
					'publishMethod' => $this->_publishMethod,
					'creativeCommon' => $this->_creativeCommons,
					'allowCopy' => $this->_copyActivity,
					'time' => $this->_time,
					'activityId' => $this->_activityId,
					'activityCreator' => $this->_creatorId
			));
			
			$result2 = $dbh->prepare("UPDATE label_activities SET label_title = :title, label_description = :description, label_image = :image, label_color = :color, label_activity_image = :activityImage, label_label_elements = :labelElements, label_click_number = :clickNumber, label_coordinates = :coordinates WHERE label_id = :labelId");
			$result2->execute(array(
					'title' => $this->_title,
					'description' => $this->_description,
					'image' => $this->_titleImage,
					'color' => $this->_themeColor,
					'activityImage' => $this->_activityImage,
					'labelElements' => base64_encode(serialize($this->_labels)),
					'clickNumber' => $this->_numOfTimesCreateWasClicked,
					'coordinates' => base64_encode(serialize($this->_coordinates)),
					'labelId' => $this->_activityId
			));
			
			$dbh = null;
			
			$this->deleteAllTemporaryFiles("TEMP", $this->_creatorId);
			
		} //function editLabelactivityToDatabase
		
		public function getLabelActivityFromServer($activityId) {
			require("../../../resources/connect.inc.php");
				
			$this->_activityId = $activityId;
			$result = $dbh->prepare("SELECT * FROM label_activities WHERE label_id = :aId");
			$result->execute(array('aId' => $this->_activityId));
			
			while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
				$this->_title = $resultRow['label_title'];
				$this->_description = $resultRow['label_description'];
				$this->_titleImage = $resultRow['label_image'];
				$this->_themeColor = $resultRow['label_color'];
				$this->_activityImage = $resultRow['label_activity_image'];
				$this->_labels = unserialize(base64_decode($resultRow['label_label_elements']));
				$this->_currentLabel = $resultRow['label_click_number'] + 2;
				$this->_numOfTimesCreateWasClicked = $resultRow['label_click_number'];
				$this->_coordinates = unserialize(base64_decode($resultRow['label_coordinates']));	
			}
			
			$result2 = $dbh->prepare("SELECT * FROM activities WHERE activity_id = :aId");
			$result2->execute(array('aId' => $this->_activityId));
			
			while($resultRow2 = $result2->fetch(PDO::FETCH_ASSOC)) {
				$this->_creatorId = $resultRow2['activity_creator'];
				$this->_activityType = $resultRow2['activity_type'];
				$this->_publishMethod = $resultRow2['activity_publish_method'];
				$this->_creativeCommons = $resultRow2['activity_creative_common'];
				$this->_copyActivity = $resultRow2['activity_allow_copy'];
			}
			
			$dbh= null; 
		} //function getLabelActivityFromServer
		
		public function getLabelActivityFromServerWithoutLogin($activityId) {
			require("../../resources/connect.inc.php");
		
			$this->_activityId = $activityId;
			$result = $dbh->prepare("SELECT * FROM label_activities WHERE label_id = :aId");
			$result->execute(array('aId' => $this->_activityId));
				
			while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
				$this->_title = $resultRow['label_title'];
				$this->_description = $resultRow['label_description'];
				$this->_titleImage = $resultRow['label_image'];
				$this->_themeColor = $resultRow['label_color'];
				$this->_activityImage = $resultRow['label_activity_image'];
				$this->_labels = unserialize(base64_decode($resultRow['label_label_elements']));
				$this->_currentLabel = $resultRow['label_click_number'] + 2;
				$this->_numOfTimesCreateWasClicked = $resultRow['label_click_number'];
				$this->_coordinates = unserialize(base64_decode($resultRow['label_coordinates']));
			}
				
			$result2 = $dbh->prepare("SELECT * FROM activities WHERE activity_id = :aId");
			$result2->execute(array('aId' => $this->_activityId));
				
			while($resultRow2 = $result2->fetch(PDO::FETCH_ASSOC)) {
				$this->_creatorId = $resultRow2['activity_creator'];
				$this->_activityType = $resultRow2['activity_type'];
				$this->_publishMethod = $resultRow2['activity_publish_method'];
				$this->_creativeCommons = $resultRow2['activity_creative_common'];
				$this->_copyActivity = $resultRow2['activity_allow_copy'];
			}
				
			$dbh= null;
		} //function getLabelActivityFromServerWithoutLogin
		
		public function getLabelActivity() {
			$label = [];
			array_push($label, $this->_activityId);
			array_push($label, $this->_title);
			array_push($label, $this->_description);
			array_push($label, $this->_titleImage);
			array_push($label, $this->_themeColor);
			array_push($label, $this->_activityImage);
			array_push($label, $this->_labels);
			array_push($label, $this->_currentLabel);
			array_push($label, $this->_numOfTimesCreateWasClicked);
			array_push($label, $this->_coordinates);
			array_push($label, $this->_publishMethod);
			array_push($label, $this->_creativeCommons);
			array_push($label, $this->_copyActivity);
			array_push($label, $this->_creatorId);
			array_push($label, $this->_activityType);
			return $label;
		} //function getLabelActivity
		
		public function setLabelActivityForEdit($actObj) {
			//activity id is already set in the method checkIfActivityIsYours() in Activity.php
			$this->_title = $actObj[1];
			$this->_description = $actObj[2];
			$this->_titleImage = $actObj[3];
			$this->_themeColor = $actObj[4];
			$this->_activityImage = $actObj[5];
			$this->_labels = $actObj[6];
			$this->_currentLabel = $actObj[7];
			$this->_numOfTimesCreateWasClicked = $actObj[8];
			$this->_coordinates = $actObj[9];
			$this->_publishMethod = $actObj[10];
			$this->_creativeCommons = $actObj[11];
			$this->_copyActivity = $actObj[12];
			$this->_creatorId = $actObj[13];
			$this->_activityType = $actObj[14];
		} //function setLabelActivityForEdit
	}
?>