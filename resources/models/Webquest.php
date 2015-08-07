<?php
	require_once("Activity.php");
	
	class Webquest extends Activity {
		private $_learningOutcomes;
		private $_overview;
		private $_links;
		private $_tasks;
		private $_questions;
		private $_evaluation;
		
		function __construct() {
			$this->_links = [];
			$this->_tasks = [];
			$this->_questions = [];
		}
		
		public function insertWebquestActivityToDatabase($title, $description, $image, $color, $learningOutcomes, $overview, $links, $tasks, $questions, $evaluation, $publishMethod, $creativeCommon, $allowCopy, $userId) {
			require("../../../resources/connect.inc.php");
			
			$this->_title = $title;
			$this->_description = $description;
			$this->_titleImage = $image;
			$this->_themeColor = $color;
			$this->_learningOutcomes = $learningOutcomes;
			$this->_overview = $overview;
			$this->_links = $links;
			$this->_tasks = $tasks;
			$this->_questions = $questions;
			$this->_evaluation = $evaluation;
			$this->_publishMethod = $publishMethod;
			$this->_creativeCommons = $creativeCommon;
			$this->_copyActivity = $allowCopy;
			$this->_creatorId = $userId;
			$this->_time = date("Y-m-d h:i:s");
			$this->_activityType = 'webq';
						
			$result = $dbh->prepare("INSERT INTO activities VALUES(:activityId, :userId, :title, :type, :publishMethod, :creativeCommon, :allowCopy, :time)");
			$result->execute(array(
					'activityId' => '',
					'userId' => $this->_creatorId,
					'title' => $this->_title,
					'type' => $this->_activityType,
					'publishMethod' => $this->_publishMethod,
					'creativeCommon' => $this->_creativeCommons,
					'allowCopy' => $this->_copyActivity,
					'time' => $this->_time
			));
			
			//need to get the activityId generated and use it for the webquestId here
			$selectResult = $dbh->prepare("SELECT activity_id FROM activities WHERE activity_creator = :userId AND activity_title = :title");
			$selectResult->execute(array('userId' => $this->_creatorId, 'title' => $this->_title));
			
			while($selectResultRow = $selectResult->fetch(PDO::FETCH_ASSOC)) {
				$this->_activityId = $selectResultRow['activity_id'];
			}
			
			//serialize the links, tasks and questions because they are array values
			$result2 = $dbh->prepare("INSERT INTO webquest_activities VALUES(:webquestId, :title, :description, :image, :color, :learningOutcomes, :overview, :links, :tasks, :questions, :evaluation)");
			$result2->execute(array(
					'webquestId' => $this->_activityId,
					'title' => $this->_title,
					'description' => $this->_description,
					'image' => $this->_titleImage,
					'color' => $this->_themeColor,
					'learningOutcomes' => $this->_learningOutcomes,
					'overview' => $this->_overview,
					'links' => base64_encode(serialize($this->_links)), 
					'tasks' => base64_encode(serialize($this->_tasks)),
					'questions' => base64_encode(serialize($this->_questions)),
					'evaluation' => $this->_evaluation
			));
			
			$dbh = null;
			
		} //function insertWebquestActivityToDatabase()
		
		public function editWebquestActivityToDatabase($activityId, $title, $description, $image, $color, $learningOutcomes, $overview, $links, $tasks, $questions, $evaluation, $publishMethod, $creativeCommon, $allowCopy, $userId) {
			require("../../../resources/connect.inc.php");
			
			$this->_activityId = $activityId;
			$this->_title = $title;
			$this->_description = $description;
			$this->_titleImage = $image;
			$this->_themeColor = $color;
			$this->_learningOutcomes = $learningOutcomes;
			$this->_overview = $overview;
			$this->_links = $links;
			$this->_tasks = $tasks;
			$this->_questions = $questions;
			$this->_evaluation = $evaluation;
			$this->_publishMethod = $publishMethod;
			$this->_creativeCommons = $creativeCommon;
			$this->_copyActivity = $allowCopy;
			$this->_creatorId = $userId;
			$this->_time = date("Y-m-d h:i:s");
			$this->_activityType = 'webq';
			
			//var_dump($this->_tasks);
			//$test = base64_encode(serialize($this->_tasks));
			//var_dump($test);
			//$test2 = unserialize(base64_decode($test));
			//var_dump($test2);
			
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
			
			$result2 = $dbh->prepare("UPDATE webquest_activities SET webquest_title = :title, webquest_description = :description, webquest_image = :image, webquest_color = :color, webquest_learning_outcomes = :learningOutcomes, webquest_overview = :overview, webquest_links = :links, webquest_tasks = :tasks, webquest_questions = :questions, webquest_evaluation = :evaluation WHERE webquest_id = :webquestId");
			$result2->execute(array(
					'title' => $this->_title,
					'description' => $this->_description,
					'image' => $this->_titleImage,
					'color' => $this->_themeColor,
					'learningOutcomes' => $this->_learningOutcomes,
					'overview' => $this->_overview,
					'links' => base64_encode(serialize($this->_links)),
					'tasks' => base64_encode(serialize($this->_tasks)),
					'questions' => base64_encode(serialize($this->_questions)),
					'evaluation' => $this->_evaluation,
					'webquestId' => $this->_activityId
			));
			
			$dbh = null;
			
		} //function editWebquestActivityToDatabase()
		
		public function getWebQuestActivityFromServer($activityId) {
			require("../../../resources/connect.inc.php");
			
			$this->_activityId = $activityId;
			$result = $dbh->prepare("SELECT * FROM webquest_activities WHERE webquest_id = :aId");
			$result->execute(array('aId' => $this->_activityId));
			
			while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
				$this->_title = $resultRow['webquest_title'];
				$this->_description = $resultRow['webquest_description'];
				$this->_titleImage = $resultRow['webquest_image'];
				$this->_themeColor = $resultRow['webquest_color'];
				$this->_learningOutcomes = $resultRow['webquest_learning_outcomes'];
				$this->_overview = $resultRow['webquest_overview'];
				$this->_links = unserialize(base64_decode($resultRow['webquest_links']));
				$this->_tasks = unserialize(base64_decode($resultRow['webquest_tasks']));
				$this->_questions = unserialize(base64_decode($resultRow['webquest_questions']));
				$this->_evaluation = $resultRow['webquest_evaluation'];
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
		} //function editWebquestActivityFromServer()
		
		public function getWebquestActivity() {
			$webquest = [];
			array_push($webquest, $this->_activityId);
			array_push($webquest, $this->_title);
			array_push($webquest, $this->_description);
			array_push($webquest, $this->_titleImage);
			array_push($webquest, $this->_themeColor);
			array_push($webquest, $this->_learningOutcomes);
			array_push($webquest, $this->_overview);
			array_push($webquest, $this->_links);
			array_push($webquest, $this->_tasks);
			array_push($webquest, $this->_questions);
			array_push($webquest, $this->_evaluation);
			array_push($webquest, $this->_publishMethod);
			array_push($webquest, $this->_creativeCommons);
			array_push($webquest, $this->_copyActivity);
			array_push($webquest, $this->_creatorId);
			array_push($webquest, $this->_activityType);
			return $webquest;
		} //function getWebquestActivity()
		
		public function setWebquestActivityForEdit($actObj) {
			//activity id is already set in the method checkIfActivityIsYours() in Activity.php			
			$this->_title = $actObj[1];
			$this->_description = $actObj[2];
			$this->_titleImage = $actObj[3];
			$this->_themeColor = $actObj[4];
			$this->_learningOutcomes = $actObj[5];
			$this->_overview = $actObj[6];
			$this->_links = $actObj[7];
			$this->_tasks = $actObj[8];
			$this->_questions = $actObj[9];
			$this->_evaluation = $actObj[10];
			$this->_publishMethod = $actObj[11];
			$this->_creativeCommons = $actObj[12];
			$this->_copyActivity = $actObj[13];
			$this->_creatorId = $actObj[14];
			$this->_activityType = $actObj[15];
		}

	}
?>