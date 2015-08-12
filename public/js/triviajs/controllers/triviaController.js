app.controller('triviaController', function($scope, $rootScope, $location, $timeout, $route, triviaQuestionFactory, triviaRandomizeFactory) {

	$scope.animating = true;
	$scope.questionActive = true;

	$scope.loadQuestion = function() {
		if($rootScope.questionNumber < triviaQuestionFactory.getTotalQuestions()) {
			var q = triviaQuestionFactory.getAQuestion($rootScope.questionNumber);		
			$rootScope.questionNumber++;
			console.log($rootScope.questionNumber);
			$scope.clickDisabled = false;
			
			$scope.question = q.question;	
			$scope.correctAnswer = q.correctAnswer;
			
			var random = triviaRandomizeFactory.getAnswersAndRandomize(q.wrongAnswer1, q.wrongAnswer2, q.wrongAnswer3, q.correctAnswer);
			triviaRandomizeFactory.clearAndReset();
	
			$scope.options = random;
		}
		else
			$scope.questionActive = false;
	};
	
	$scope.answerMode = true;
	$scope.answerQuestion = function(choice) {
		
		if(choice == $scope.correctAnswer) {
			$scope.correctAns = true;
			$scope.clickDisabled = true;
			//$scope.loadQuestion();
			
			if($rootScope.scoreType == "dollars" || $rootScope.scoreType == "points")
				$rootScope.score += 100;
			else 
				$rootScope.score += 1;
			
			$timeout(function() { $location.path('/triviaSecond'); }, 2000);
		}
		else {
			$scope.correctAns = false;
			$scope.clickDisabled = true;
			$timeout(function() { $location.path('/triviaSecond'); }, 2000);
		}
		
		$scope.answerMode = false; //display the correct or not correct message
	};
	
	$scope.playAgain = function() {
		$rootScope.questionNumber = 0;
		
		if($rootScope.scoreType == "dollars" || $rootScope.scoreType == "points")
			$rootScope.score = 0;
		else 
			$rootScope.score = 1;
		
		$route.reload();
	};
});