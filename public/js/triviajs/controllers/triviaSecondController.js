app.controller('triviaSecondController', function($scope, $rootScope, $location, $timeout, triviaQuestionFactory, triviaRandomizeFactory) {

	$scope.animating = true;
	$scope.loadQuestion = function() {
		$rootScope.questionNumber++;
		console.log($rootScope.questionNumber);
		$scope.clickDisabled = false;
		
		var q = triviaQuestionFactory.getAQuestion($rootScope.questionNumber - 1);
		$scope.question = q.question;		
		$scope.correctAnswer = q.correctAnswer;

		var random = triviaRandomizeFactory.getAnswersAndRandomize(q.wrongAnswer1, q.wrongAnswer2, q.wrongAnswer3, q.correctAnswer);
		triviaRandomizeFactory.clearAndReset();
		
		$scope.options = random;
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
			
			$timeout(function() { $location.path('/trivia'); }, 2500);
		}
		else {
			$scope.correctAns = false;
			$scope.clickDisabled = true;
			$timeout(function() { $location.path('/trivia'); }, 2500);
		}
		
		$scope.answerMode = false; //display the correct or not correct message
	};
});