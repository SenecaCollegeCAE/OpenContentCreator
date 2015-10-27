<?php
	class Activity {
		protected $_activityId;
		protected $_title;
		protected $_description;
		protected $_titleImage;
		protected $_themeColor;
		protected $_publishMethod;
		protected $_creativeCommons;
		protected $_copyActivity;
		protected $_creatorId;
		protected $_time;
		protected $_activityType;
		protected $_copied;
		
		public function userUploadFile($file, $fileTemp, $userName) {
			$targetDirectory = "../../../public/img/users/" . $userName . "/";
			$tempString = explode(".", $file);
			$extension = end($tempString);
			$pictureName = reset($tempString);
			$filenameAddon = substr(uniqid(mt_rand(), true), 0, 7); //generates a random string with 7 digits
				
			$this->_titleImage = $targetDirectory . basename($pictureName) . $filenameAddon . "." . $extension;
			
			
			move_uploaded_file($fileTemp, $this->_titleImage);
			return $this->_titleImage;
			
		} //function userUploadFile($file, $userId)
		
		public function deleteUploadedFileFromBefore($file, $userName) {
			unlink($file);
		} //function deleteUploadedFileFromBefore
		
		public function checkIfActivityIsYours($userId, $actId) {
			require_once("../../../resources/connect.inc.php");

			$this->_activityId = $actId;
			
			$result = $dbh->prepare("SELECT activity_creator FROM activities WHERE activity_id = :actId");
			$result->execute(array('actId' => $this->_activityId));
			$dbh = null;
				
			while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
				if($resultRow['activity_creator'] == $userId)
					return true;
				else
					return false;
			}
				
		} //function checkIfActivityIsYours($userId, $actId)
		
		public function checkForDuplicateTitle($actTitle) {
			require_once("../../../resources/connect.inc.php");
			
			$this->_title = $actTitle;
			
			$result = $dbh->prepare("SELECT activity_title FROM activities WHERE activity_title = :actTitle");
			$result->execute(array('actTitle' => $this->_title));
			$resultNum = $result->rowCount();
			$dbh = null;
			
			if($resultNum)
				return true;
			else
				return false;
			
		} //function checkForDuplicateTitle($actTitle)
		
		public function getTypeOfActivity($actId) {
			require("../../../resources/connect.inc.php");
			
			$this->_activityId = $actId;
			$result = $dbh->prepare("SELECT activity_type FROM activities WHERE activity_id = :aId");
			$result->execute(array('aId' => $this->_activityId));
			$dbh = null;
			
			while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
				$type = $resultRow['activity_type'];
			}
			
			return $type;
		} //function getTypeOfActivity($actId)
		
		//public function
		
		public function getAllActitivesCreatedByUser($userId) {
			require("../../../resources/connect.inc.php");

			$this->_creatorId = $userId;
			$this->_copied = 'no';
			$result = $dbh->prepare("SELECT activity_id, activity_title FROM activities WHERE activity_creator = :userId AND activity_copied = :copied ORDER BY activity_title ASC");
			$result->execute(array('userId' => $this->_creatorId, 'copied' => $this->_copied));
			$dbh = null;
			
			$activitiesArray = [];
			while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
				$activitiesArray[$resultRow['activity_id']] = $resultRow['activity_title'];
			}
			
			return $activitiesArray;
			
		} //function getAllActitivesCreatedByUser($userId)
		
		public function getAllActivitiesCopiedByUser($userId) {
			require("../../../resources/connect.inc.php");
			
			$this->_creatorId = $userId;
			$this->_copied = 'yes';
			$result = $dbh->prepare("SELECT activity_id, activity_title FROM activities WHERE activity_creator = :userId AND activity_copied = :copied ORDER BY activity_title ASC");
			$result->execute(array('userId' => $this->_creatorId, 'copied' => $this->_copied));
			$dbh = null;
			
			$activitiesArray = [];
			while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
				$activitiesArray[$resultRow['activity_id']] = $resultRow['activity_title'];
			}
			
			return $activitiesArray;
		} //function getAllActivitiesCopiedByUser($userId)
		
		public function getActivityTypeWithoutLoggingIn($activityId) {
			require_once("../../resources/connect.inc.php");
			
			$this->_activityId = $activityId;
			
			//Check if activityId is an integer
			if(is_int($this->_activityId)) {
				$result = $dbh->prepare("SELECT activity_type FROM activities WHERE activity_id = :aId");
				$result->execute(array('aId' => $this->_activityId));
				$resultNum = $result->rowCount();
				$dbh = null;
				
				if($resultNum) {
					while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
						$this->_activityType = $resultRow['activity_type'];
					}
					
					return $this->_activityType;
				}
			}
			else {
				return "";
			}		
		} //function getActivityWithoutLoggingIn
		
		public function getActivityThatIsNotYoursAndMakeACopy($aId, $uId) {
			$this->_activityId = $aId;
			$this->_creatorId = $uId;
			$this->_time = date("Y-m-d h:i:s");
			$aType = $this->getTypeOfActivity($aId);
			$this->_activityType = $aType;
			$this->_copied = 'yes';
			
			require("../../../resources/connect.inc.php");
			
			$sql = "INSERT INTO activities(activity_creator, activity_title, activity_type, activity_publish_method, activity_creative_common, activity_allow_copy, activity_time, activity_copied) SELECT '". $this->_creatorId ."', activity_title, activity_type, activity_publish_method, activity_creative_common, activity_allow_copy, '". $this->_time ."', '". $this->_copied . "' FROM activities WHERE activity_id = ". $this->_activityId;
			$result = $dbh->prepare($sql);
			$result->execute();
			
			$getResult = $dbh->prepare("SELECT activity_id FROM activities ORDER BY activity_id DESC LIMIT 1");
			$getResult->execute();
			while($getResultRow = $getResult->fetch(PDO::FETCH_ASSOC)) {
				$newActivityId = $getResultRow['activity_id'];
			}
			
			switch($this->_activityType) {
				case 'webq':
					$sql2 = "INSERT INTO webquest_activities(webquest_id, webquest_title, webquest_description, webquest_image, webquest_color, webquest_learning_outcomes, webquest_overview, webquest_links, webquest_tasks, webquest_questions, webquest_evaluation) SELECT '". $newActivityId ."', webquest_title, webquest_description, webquest_image, webquest_color, webquest_learning_outcomes, webquest_overview, webquest_links, webquest_tasks, webquest_questions, webquest_evaluation FROM webquest_activities WHERE webquest_id = ". $this->_activityId;
					$result2 = $dbh->prepare($sql2);
					$result2->execute();
					break;
					
				case 'trivia':
					$sql2 = "INSERT INTO trivia_activities(trivia_id, trivia_title, trivia_description, trivia_image, trivia_color, trivia_pointstyle, trivia_lifeline_5050, trivia_lifeline_hint, trivia_lifeline_audience, trivia_difficulties, trivia_questions, trivia_correct_answers, trivia_wrong_answers1, trivia_wrong_answers2, trivia_wrong_answers3, trivia_hints) SELECT '". $newActivityId ."', trivia_title, trivia_description, trivia_image, trivia_color, trivia_pointstyle, trivia_lifeline_5050, trivia_lifeline_hint, trivia_lifeline_audience, trivia_difficulties, trivia_questions, trivia_correct_answers, trivia_wrong_answers1, trivia_wrong_answers2, trivia_wrong_answers3, trivia_hints FROM trivia_activities WHERE trivia_id = ". $this->_activityId;
					$result2 = $dbh->prepare($sql2);
					$result2->execute();
					break;
					
				case 'label':
					$sql2 = "INSERT INTO label_activities(label_id, label_title, label_description, label_image, label_color, label_activity_image, label_label_elements, label_click_number, label_coordinates) SELECT '". $newActivityId ."', label_title, label_description, label_image, label_color, label_activity_image, label_label_elements, label_click_number, label_coordinates FROM label_activities WHERE label_id = ". $this->_activityId;
					$result2 = $dbh->prepare($sql2);
					$result2->execute();
					break;
					
				default:
			}
			
			$dbh = null;
		} //function getActivityThatIsNotYoursAndMakeACopy
		
		public function getYourOwnActivityAndMakeACopy($aId, $uId) {
			$this->_activityId = $aId;
			$this->_creatorId = $uId;
			$this->_time = date("Y-m-d h:i:s");
			$aType = $this->getTypeOfActivity($aId);
			$this->_activityType = $aType;
			
			require("../../../resources/connect.inc.php");
			$sql = "INSERT INTO activities(activity_creator, activity_title, activity_type, activity_publish_method, activity_creative_common, activity_allow_copy, activity_time, activity_copied) SELECT '". $this->_creatorId ."', activity_title, activity_type, activity_publish_method, activity_creative_common, activity_allow_copy, '". $this->_time ."', activity_copied FROM activities WHERE activity_id = ". $this->_activityId . " AND activity_creator = " . $this->_creatorId;
			$result = $dbh->prepare($sql);
			$result->execute();
			
			$getResult = $dbh->prepare("SELECT activity_id FROM activities ORDER BY activity_id DESC LIMIT 1");
			$getResult->execute();
			while($getResultRow = $getResult->fetch(PDO::FETCH_ASSOC)) {
				$newActivityId = $getResultRow['activity_id'];
			}
				
			switch($this->_activityType) {
				case 'webq':
					$sql2 = "INSERT INTO webquest_activities(webquest_id, webquest_title, webquest_description, webquest_image, webquest_color, webquest_learning_outcomes, webquest_overview, webquest_links, webquest_tasks, webquest_questions, webquest_evaluation) SELECT '". $newActivityId ."', webquest_title, webquest_description, webquest_image, webquest_color, webquest_learning_outcomes, webquest_overview, webquest_links, webquest_tasks, webquest_questions, webquest_evaluation FROM webquest_activities WHERE webquest_id = ". $this->_activityId;
					$result2 = $dbh->prepare($sql2);
					$result2->execute();
					break;
						
				case 'trivia':
					$sql2 = "INSERT INTO trivia_activities(trivia_id, trivia_title, trivia_description, trivia_image, trivia_color, trivia_pointstyle, trivia_lifeline_5050, trivia_lifeline_hint, trivia_lifeline_audience, trivia_difficulties, trivia_questions, trivia_correct_answers, trivia_wrong_answers1, trivia_wrong_answers2, trivia_wrong_answers3, trivia_hints) SELECT '". $newActivityId ."', trivia_title, trivia_description, trivia_image, trivia_color, trivia_pointstyle, trivia_lifeline_5050, trivia_lifeline_hint, trivia_lifeline_audience, trivia_difficulties, trivia_questions, trivia_correct_answers, trivia_wrong_answers1, trivia_wrong_answers2, trivia_wrong_answers3, trivia_hints FROM trivia_activities WHERE trivia_id = ". $this->_activityId;
					$result2 = $dbh->prepare($sql2);
					$result2->execute();
					break;
						
				case 'label':
					$sql2 = "INSERT INTO label_activities(label_id, label_title, label_description, label_image, label_color, label_activity_image, label_label_elements, label_click_number, label_coordinates) SELECT '". $newActivityId ."', label_title, label_description, label_image, label_color, label_activity_image, label_label_elements, label_click_number, label_coordinates FROM label_activities WHERE label_id = ". $this->_activityId;
					$result2 = $dbh->prepare($sql2);
					$result2->execute();
					break;
						
				default:
			}
				
			$dbh = null;
		} //function getActivityThatIsNotYoursAndMakeACopy
		
	}
?>