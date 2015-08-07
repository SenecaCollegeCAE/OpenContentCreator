<?php
	class Search {
		private $_activityId;
		private $_activityTitle;
		private $_activityType;
		private $_activityByUser;
		private $_activityTimeCreated;
		private $_activityPlaceHolderImage;
		
		public function __construct() {
			$this->_activityId = [];
			$this->_activityName = [];
			$this->_activityType = [];
			$this->_activityByUser = [];
			$this->_activityTimeCreated = [];
			$this->_activityPlaceHolderImage = [];
		}
		
		public function getActivityNotLoggedIn($searchString) {
			require_once("../../resources/connect.inc.php");
			
			$result = $dbh->prepare("SELECT * FROM activities WHERE activity_title LIKE :search AND activity_publish_method = 'Public' ORDER BY activity_title");
			$result->execute(array('search' => '%' . $searchString . '%'));
			$resultNum = $result->rowCount();
			$dbh = null;
			
			if($resultNum) {
				while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
					//Returns multiple results, so need to put it in an array of things
					array_push($this->_activityId, $resultRow['activity_id']);
					array_push($this->_activityTitle, $resultRow['activity_title']);
					array_push($this->_activityType, $resultRow['activity_type']);
					array_push($this->_activityByUser, $resultRow['activity_creator']);
					array_push($this->_activityTimeCreated, $resultRow['activity_time']);
					
					if($resultRow['activity_type'] == "webq")
						$this->_activityPlaceHolderImage = "./public/content/search_webq.png";
					else if($resultRow['activity_type'] == "label")
						$this->_activityPlaceHolderImage = "./public/content/search_label.png";
					else if($resultRow['activity_type'] == "trivia")
						$this->_activityPlaceHolderImage = "./public/content/search_trivia.png";
						
				} //while
					
				return true;
			}
			else {
				return false;
			}
		} //function getActivityNotLoggedIn($searchString)
		
		public function getActivityLoggedIn($searchString) {
			require_once("../../../resources/connect.inc.php");
			
			$result = $dbh->prepare("SELECT * FROM activities WHERE activity_title LIKE :search AND activity_publish_method = 'Public' ORDER BY activity_title");
			$result->execute(array('search' => '%' . $searchString . '%'));
			$resultNum = $result->rowCount();
			$dbh = null;
				
			if($resultNum) {
				while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
					//Returns multiple results, so need to put it in an array of things
					array_push($this->_activityId, $resultRow['activity_id']);
					array_push($this->_activityTitle, $resultRow['activity_title']);
					array_push($this->_activityType, $resultRow['activity_type']);
					array_push($this->_activityByUser, $resultRow['activity_creator']);
					array_push($this->_activityTimeCreated, $resultRow['activity_time']);
						
					if($resultRow['activity_type'] == "webq")
						$this->_activityPlaceHolderImage = "./public/content/search_webq.png";
					else if($resultRow['activity_type'] == "label")
						$this->_activityPlaceHolderImage = "./public/content/search_label.png";
					else if($resultRow['activity_type'] == "trivia")
						$this->_activityPlaceHolderImage = "./public/content/search_trivia.png";
			
				} //while
					
				return true;
			}
			else {
				return false;
			}
			
		} //function getActivityLoggedIn($searchString)
		
		public function printResults() {
			$returnString = "<ol>";
			
			for($i = 0; $i < ($this->_activityId).length; $i++) {
				if($this->_activityType[i] == "webq")
					$returnString .= "<li><a href='webquest/display.php?aId=" . $this->_activityId[i] ."'><img src='". $this->_activityPlaceHolderImage[i] . "'></a></li>";
				
			}
			
			$returnString .= "</ol>";
			
			return $returnString;
		} //function  printResults()
		
		public function resetInfoAfterSearching() {
			$this->_activityId = [];
			$this->_activityTitle = [];
			$this->_activityType = [];
			$this->_activityByUser = [];
			$this->_activityTimeCreated = [];
			$this->_activityPlaceHolderImage = [];
		} //function resetInfoAfterSearching()
	}
?>