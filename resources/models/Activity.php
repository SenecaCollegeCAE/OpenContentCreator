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
			require_once("../../../resources/connect.inc.php");
			
			$this->_activityId = $actId;
			$result = $dbh->prepare("SELECT activity_type FROM activities WHERE activity_id = :aId");
			$result->execute(array('aId' => $this->_activityId));
			$dbh = null;
			
			while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
				$type = $resultRow['activity_type'];
			}
			
			return $type;
		} //function getTypeOfActivity($actId)
		
		public function getAllActitivesCreatedByUser($userId) {
			require_once("../../../resources/connect.inc.php");

			$this->_creatorId = $userId;
			$result = $dbh->prepare("SELECT activity_id, activity_title FROM activities WHERE activity_creator = :userId");
			$result->execute(array('userId' => $this->_creatorId));
			$dbh = null;
			
			$activitiesArray = [];
			while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
				$activitiesArray[$resultRow['activity_id']] = $resultRow['activity_title'];
			}
			
			return $activitiesArray;
			
		} //function getAllActitivesCreatedByUser($userId)
		
		public function getAllActivitiesCopiedByUser($userId) {
			
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
		
	}
?>