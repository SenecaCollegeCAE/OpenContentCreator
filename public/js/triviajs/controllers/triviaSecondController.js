app.controller('triviaSecondController', function($scope, $rootScope, $location, $timeout, $route, $window, triviaQuestionFactory, triviaRandomizeFactory) {

	$scope.animating = true;
	$scope.questionActive = true;
	
	$scope.loadQuestion = function() {
		if($rootScope.questionNumber < triviaQuestionFactory.getTotalQuestions()) {
			$rootScope.questionNumber++; 
			
			//get the question and set it & randomize the answers
			var q = triviaQuestionFactory.getAQuestion($rootScope.questionNumber - 1);

			console.log($rootScope.questionNumber);
			$scope.clickDisabled = false;			
			$scope.question = q.question;	
			$scope.correctAnswer = q.correctAnswer;
			
			var random = triviaRandomizeFactory.getAnswersAndRandomize(q.wrongAnswer1, q.wrongAnswer2, q.wrongAnswer3, q.correctAnswer);
			triviaRandomizeFactory.clearAndReset();	
			$scope.options = random;
			
			//get the hint to a question if any
			console.log(q.hint);
		}
		else {
			$scope.questionActive = false;
		}
	};
	
	$scope.chooseLifeLine5050 = function() {
		if($rootScope.lifeLine5050 > 0) {
			var ca = triviaQuestionFactory.getCorrectAnswerToQuestion($rootScope.questionNumber - 1);
			var q = triviaQuestionFactory.getAQuestion($rootScope.questionNumber - 1);
			var origAnswers = $scope.options;
			
			//open a new window passing the possiblevalues to it
			$window.possibleAnswers = triviaRandomizeFactory.getLifeline5050Values(q.wrongAnswer1, q.wrongAnswer2, q.wrongAnswer3, ca, origAnswers);
			$window.open("triviapopuplifeline5050.php", "triviaPopUpWindow", "width=400, height=200, left=100, top=100, directories=no, titlebar=no, toolbar=no, scrollbar=yes, resizable=no, menubar=no, status=no, location=no");
			
			$rootScope.lifeLine5050--;			
		}
	};
	
	$scope.chooseLifeLineHint = function() {
		if($rootScope.lifeLineHint > 0) {
			var q = triviaQuestionFactory.getAQuestion($rootScope.questionNumber - 1);
			
			//get the hint to a question if any
			$window.hint = q.hint;
			$window.open("triviapopuplifelinehint.php", "triviaPopUpWindow", "width=400, height=200, left=100, top=100, directories=no, titlebar=no, toolbar=no, scrollbar=yes, resizable=no, menubar=no, status=no, location=no");
			
			$rootScope.lifeLineHint--;
		}
	};
	
	$scope.chooseLifeLineAudience = function() {
		if($rootScope.lifeLineAudience > 0) {
			
			$window.open("triviapopuplifelineaudience.php", "triviaPopUpWindow", "width=430, height=580, left=100, top=100, directories=no, titlebar=no, toolbar=no, scrollbar=yes, resizable=no, menubar=no, status=no, location=no");
			$rootScope.lifeLineAudience--;
		}
	};
	
	$scope.answerMode = true;
	$scope.answerQuestion = function(choice) {
		
		if(choice == $scope.correctAnswer) {
			$scope.correctAns = true;
			$scope.clickDisabled = true;
			
			if($rootScope.scoreType == "dollars" || $rootScope.scoreType == "points")
				$rootScope.score += 100;
			else 
				$rootScope.score += 1;
			
			$timeout(function() { $location.path('/trivia'); }, 2000);
		}
		else {
			$scope.correctAns = false;
			$scope.clickDisabled = true;
			$timeout(function() { $location.path('/trivia'); }, 2000);
		}
		
		$scope.answerMode = false; //display the correct or not correct message
	};
	
	$scope.playAgain = function() {
		$rootScope.questionNumber = 0;
		var ll = triviaQuestionFactory.getLifeline();
		$rootScope.lifeLine5050 = ll[0].lifeLine5050;
		$rootScope.lifeLineHint = ll[1].lifeLineHint;
		$rootScope.lifeLineAudience = ll[2].lifeLineAudience;
		
		if($rootScope.scoreType == "dollars" || $rootScope.scoreType == "points")
			$rootScope.score = 0;
		else 
			$rootScope.score = 1;
		
		$route.reload();
	};
});