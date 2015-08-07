app.controller('triviaController', function($scope, $rootScope, $location, triviaFactory) {

	$scope.animating = true;

	$scope.loadQuestion = function() {
		$rootScope.questionNumber++;
		console.log($rootScope.questionNumber);
		var random = [];
		
		var q = triviaFactory.getAQuestion($rootScope.questionNumber - 1);
		$scope.question = q.question;
		
		$scope.correctAnswer = q.correctAnswer;
		var tempArray = [];
		var tempNumber = 4;
		
		tempArray.push(q.wrongAnswer1, q.wrongAnswer2, q.wrongAnswer3, q.correctAnswer);
		
		for(var i = 0; i < 4; i++) {
			var randomNumber = Math.floor(Math.random() * tempNumber); //get a random number 0 - 3
			var tempItem = tempArray[randomNumber]; //get the element from the random number
					
			tempArray.splice(randomNumber, 1);
			random.push(tempItem);
			tempNumber--;
		}
		
		$scope.options = random;
	};
	
	$scope.answerMode = true;
	$scope.answerQuestion = function(choice) {
		
		if(choice == $scope.correctAnswer) {
			$scope.correctAns = true;
			//$scope.loadQuestion();
			$location.path('/triviaSecond');
		}
		else {
			$scope.correctAns = false;
		}
		
		$scope.answerMode = false; //display the correct or not correct message
	};
});