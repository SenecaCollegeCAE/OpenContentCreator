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
			$this->_activityTitle = [];
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
						array_push($this->_activityPlaceHolderImage, "../../public/img/layout/search_webq.png");
					else if($resultRow['activity_type'] == "label")
						array_push($this->_activityPlaceHolderImage, "../../public/img/layout/search_label.png");
					else if($resultRow['activity_type'] == "trivia")
						array_push($this->_activityPlaceHolderImage, "../../public/img/layout/search_trivia.png");
						
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
						array_push($this->_activityPlaceHolderImage, "../../../public/img/layout/search_webq.png");
					else if($resultRow['activity_type'] == "label")
						array_push($this->_activityPlaceHolderImage, "../../../public/img/layout/search_label.png");
					else if($resultRow['activity_type'] == "trivia")
						array_push($this->_activityPlaceHolderImage, "../../../public/img/layout/search_trivia.png");
			
				} //while
					
				return true;
			}
			else {
				return false;
			}
			
		} //function getActivityLoggedIn($searchString)
		
		public function printResults() {
			$returnString = "<ol>";
			
			for($i = 0; $i < count($this->_activityId); $i++) {
				if($this->_activityType[$i] == "webq")
					$returnString .= "<li><div class='searchresultbox'><div class='leftsearchresult'><a href='./displayactivity.php?activityNumber=" . $this->_activityId[$i] ."'><img src='". $this->_activityPlaceHolderImage[$i] . "' alt='webquest_image'></a></div><div class='rightsearchresult'><ul><li><span class='listbold'>Name: </span>" . $this->_activityTitle[$i] . "</li><li><span class='listbold'>Type: </span>" . $this->_activityType[$i] . "</li><li><span class='listbold'>Modified: </span>" . $this->_activityTimeCreated[$i] . "</li></ul></div></div></li><hr /><br />";
				else if($this->_activityType[$i] == "label")
					$returnString .= "<li><div class='searchresultbox'><div class='leftsearchresult'><a href='./displayactivity.php?activityNumber=" . $this->_activityId[$i] ."'><img src='". $this->_activityPlaceHolderImage[$i] . "' alt='label_image'></a></div><div class='rightsearchresult'><ul><li><span class='listbold'>Name: </span>" . $this->_activityTitle[$i] . "</li><li><span class='listbold'>Type: </span>" . $this->_activityType[$i] . "</li><li><span class='listbold'>Modified: </span>" . $this->_activityTimeCreated[$i] . "</li></ul></div></div></li><hr /><br />";
				else if($this->_activityType[$i] == "trivia")
					$returnString .= "<li><div class='searchresultbox'><div class='leftsearchresult'><a href='./displayactivity.php?activityNumber=" . $this->_activityId[$i] ."'><img src='". $this->_activityPlaceHolderImage[$i] . "' alt='trivia_image'></a></div><div class='rightsearchresult'><ul><li><span class='listbold'>Name: </span>" . $this->_activityTitle[$i] . "</li><li><span class='listbold'>Type: </span>" . $this->_activityType[$i] . "</li><li><span class='listbold'>Modified: </span>" . $this->_activityTimeCreated[$i] . "</li></ul></div></div></li><hr /><br />";			
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