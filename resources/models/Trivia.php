<?php
	require_once("Activity.php");
	
	class Trivia extends Activity {
		private $_pointStyle;
		private $_lifeLines5050;
		private $_lifeLinesHint;
		private $_lifeLinesAudience;
		private $_difficulty;
		private $_questions;
		private $_correctAnswers;
		private $_wrongAnswers1;
		private $_wrongAnswers2;
		private $_wrongAnswers3;
		private $_hints;
		//private $_easyRandomize; //Maybe??
		
		function __construct() {
			$this->_difficulty = [];
			$this->_questions = [];
			$this->_correctAnswers = [];
			$this->_wrongAnswers1 = [];
			$this->_wrongAnswers2 = [];
			$this->_wrongAnswers3 = [];
			$this->_hints = [];
		}
		
		public function insertTriviaActivityToDatabase($title, $description, $image, $color, $pointStyle, $lifeLines5050, $lifeLineHint, $lifeLineAudience, $difficulty, $questions, $correctAnswers, $wrongAnswers1, $wrongAnswers2, $wrongAnswers3, $hints, $publishMethod, $creativeCommon, $allowCopy, $userId) {
			require("../../../resources/connect.inc.php");

			$this->_title = $title;
			$this->_description = $description;
			$this->_titleImage = $image;
			$this->_themeColor = $color;
			$this->_pointStyle = $pointStyle;
			$this->_lifeLines5050 = $lifeLines5050;
			$this->_lifeLinesHint = $lifeLineHint;
			$this->_lifeLinesAudience = $lifeLineAudience;
			$this->_difficulty = $difficulty;
			$this->_questions = $questions;
			$this->_correctAnswers = $correctAnswers;
			$this->_wrongAnswers1 = $wrongAnswers1;
			$this->_wrongAnswers2 = $wrongAnswers2;
			$this->_wrongAnswers3 = $wrongAnswers3;
			$this->_hints = $hints;
			$this->_publishMethod = $publishMethod;
			$this->_creativeCommons = $creativeCommon;
			$this->_copyActivity = $allowCopy;
			$this->_creatorId = $userId;
			$this->_time = date("Y-m-d h:i:s");
			$this->_activityType = 'trivia';
			
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
			
			//need to get the activityId generated and use it for the triviaId here
			$selectResult = $dbh->prepare("SELECT activity_id FROM activities WHERE activity_creator = :userId AND activity_title = :title");
			$selectResult->execute(array('userId' => $this->_creatorId, 'title' => $this->_title));
			
			while($selectResultRow = $selectResult->fetch(PDO::FETCH_ASSOC)) {
				$this->_activityId = $selectResultRow['activity_id'];
			}
			
			//serialize the difficulty, question, correct answer, wrong answer 1, 2, 3 and hints
			$result2 = $dbh->prepare("INSERT INTO trivia_activities VALUES(:triviaId, :title, :description, :image, :color, :pointStyle, :lifeLine5050, :lifeLineHint, :lifeLineAudience, :difficulties, :questions, :correctAnswers, :wrongAnswers1, :wrongAnswers2, :wrongAnswers3, :hint)");
			$result2->execute(array(
					'triviaId' => $this->_activityId,
					'title' => $this->_title,
					'description' => $this->_description,
					'image' => $this->_titleImage,
					'color' => $this->_themeColor,
					'pointStyle' => $this->_pointStyle,
					'lifeLine5050' => $this->_lifeLines5050,
					'lifeLineHint' => $this->_lifeLinesHint,
					'lifeLineAudience' => $this->_lifeLinesAudience,
					'difficulties' => base64_encode(serialize($this->_difficulty)),
					'questions' => base64_encode(serialize($this->_questions)),
					'correctAnswers' => base64_encode(serialize($this->_correctAnswers)),
					'wrongAnswers1' => base64_encode(serialize($this->_wrongAnswers1)),
					'wrongAnswers2' => base64_encode(serialize($this->_wrongAnswers2)),
					'wrongAnswers3' => base64_encode(serialize($this->_wrongAnswers3)),
					'hint' => base64_encode(serialize($this->_hints))
			));
			
			$dbh = null;
			
		} //function insertTriviaActivityToDatabase
		
		public function editTriviaActivityToDatabase($activityId, $title, $description, $image, $color, $pointStyle, $lifeLines5050, $lifeLineHint, $lifeLineAudience, $difficulty, $questions, $correctAnswers, $wrongAnswers1, $wrongAnswers2, $wrongAnswers3, $hints, $publishMethod, $creativeCommon, $allowCopy, $userId) {
			require("../../../resources/connect.inc.php");
			
			$this->_activityId = $activityId;
			$this->_title = $title;
			$this->_description = $description;
			$this->_titleImage = $image;
			$this->_themeColor = $color;
			$this->_pointStyle = $pointStyle;
			$this->_lifeLines5050 = $lifeLines5050;
			$this->_lifeLinesHint = $lifeLineHint;
			$this->_lifeLinesAudience = $lifeLineAudience;
			$this->_difficulty = $difficulty;
			$this->_questions = $questions;
			$this->_correctAnswers = $correctAnswers;
			$this->_wrongAnswers1 = $wrongAnswers1;
			$this->_wrongAnswers2 = $wrongAnswers2;
			$this->_wrongAnswers3 = $wrongAnswers3;
			$this->_hints = $hints;
			$this->_publishMethod = $publishMethod;
			$this->_creativeCommons = $creativeCommon;
			$this->_copyActivity = $allowCopy;
			$this->_creatorId = $userId;
			$this->_time = date("Y-m-d h:i:s");
			$this->_activityType = 'trivia';
			
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
			
			$result2 = $dbh->prepare("UPDATE trivia_activities SET trivia_title = :title, trivia_description = :description, trivia_image = :image, trivia_color = :color, trivia_pointstyle = :pointstyle, trivia_lifeline_5050 = :lifeline5050, trivia_lifeline_hint = :lifelinehint, trivia_lifeline_audience = :lifelineaudience, trivia_difficulties = :difficulties, trivia_questions = :questions, trivia_correct_answers = :canswers, trivia_wrong_answers1 = :wanswers1, trivia_wrong_answers2 = :wanswers2, trivia_wrong_answers3 = :wanswers3, trivia_hints = :hints WHERE trivia_id = :triviaId");
			$result2->execute(array(
					'title' => $this->_title,
					'description' => $this->_description,
					'image' => $this->_titleImage,
					'color' => $this->_themeColor,
					'pointstyle' => $this->_pointStyle,
					'lifeline5050' => $this->_lifeLines5050,
					'lifelinehint' => $this->_lifeLinesHint,
					'lifelineaudience' => $this->_lifeLinesAudience,
					'difficulties' => base64_encode(serialize($this->_difficulty)),
					'questions' => base64_encode(serialize($this->_questions)),
					'canswers' => base64_encode(serialize($this->_correctAnswers)),
					'wanswers1' => base64_encode(serialize($this->_wrongAnswers1)),
					'wanswers2' => base64_encode(serialize($this->_wrongAnswers2)),
					'wanswers3' => base64_encode(serialize($this->_wrongAnswers3)),
					'hints' => base64_encode(serialize($this->_hints)),
					'triviaId' => $this->_activityId
			));
			
			$dbh = null;
			
		} //function editTriviaActivityToDatabase()
		
		public function checkIfActivityIsYours($userId, $actId) {
			require("../../../resources/connect.inc.php");
		
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
		
		public function getTriviaActivityFromServer($activityId) {
			require("../../../resources/connect.inc.php");
			
			$this->_activityId = $activityId;
			$result = $dbh->prepare("SELECT * FROM trivia_activities WHERE trivia_id = :aId");
			$result->execute(array('aId' => $this->_activityId));
			
			while($resultRow = $result->fetch(PDO::FETCH_ASSOC)) {
				$this->_title = $resultRow['trivia_title'];
				$this->_description = $resultRow['trivia_description'];
				$this->_titleImage = $resultRow['trivia_image'];
				$this->_themeColor = $resultRow['trivia_color'];
				$this->_pointStyle = $resultRow['trivia_pointstyle'];
				$this->_lifeLines5050 = $resultRow['trivia_lifeline_5050'];
				$this->_lifeLinesHint = $resultRow['trivia_lifeline_hint'];
				$this->_lifeLinesAudience = $resultRow['trivia_lifeline_audience'];
				$this->_difficulty = unserialize(base64_decode($resultRow['trivia_difficulties']));
				$this->_questions = unserialize(base64_decode($resultRow['trivia_questions']));
				$this->_correctAnswers = unserialize(base64_decode($resultRow['trivia_correct_answers']));
				$this->_wrongAnswers1 = unserialize(base64_decode($resultRow['trivia_wrong_answers1']));
				$this->_wrongAnswers2 = unserialize(base64_decode($resultRow['trivia_wrong_answers2']));
				$this->_wrongAnswers3 = unserialize(base64_decode($resultRow['trivia_wrong_answers3']));
				$this->_hints = unserialize(base64_decode($resultRow['trivia_hints']));
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
		} //function getTriviaActivityFromServer
		
		public function getTriviaActivity() {
			$trivia = [];
			array_push($trivia, $this->_activityId);
			array_push($trivia, $this->_title);
			array_push($trivia, $this->_description);
			array_push($trivia, $this->_titleImage);
			array_push($trivia, $this->_themeColor);
			array_push($trivia, $this->_pointStyle);
			array_push($trivia, $this->_lifeLines5050);
			array_push($trivia, $this->_lifeLinesHint);
			array_push($trivia, $this->_lifeLinesAudience);
			array_push($trivia, $this->_difficulty);
			array_push($trivia, $this->_questions);
			array_push($trivia, $this->_correctAnswers);
			array_push($trivia, $this->_wrongAnswers1);
			array_push($trivia, $this->_wrongAnswers2);
			array_push($trivia, $this->_wrongAnswers3);
			array_push($trivia, $this->_hints);
			array_push($trivia, $this->_publishMethod);
			array_push($trivia, $this->_creativeCommons);
			array_push($trivia, $this->_copyActivity);
			array_push($trivia, $this->_creatorId);
			array_push($trivia, $this->_activityType);
			return $trivia;
		} //function getTriviaActivity()
		
		public function setTriviaActivityForEdit($actObj) {
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