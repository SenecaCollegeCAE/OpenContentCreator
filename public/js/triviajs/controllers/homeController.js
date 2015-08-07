app.controller('homeController', function($scope, $rootScope, $location, triviaFactory) {
	if(angular.element("main").hasClass('slider'))
		$scope.animating = true;
	else
		$scope.animating = false;
	
	$rootScope.questionNumber = 0;
	
	$scope.startTrivia = function(randomized) {	
		for(var i = 0; i < randomized.length; i++) {
			triviaFactory.setIntoAQuestion("question", randomized[i][0]);
			triviaFactory.setIntoAQuestion("correctAnswer", randomized[i][1]);
			triviaFactory.setIntoAQuestion("wrongAnswer1", randomized[i][2]);
			triviaFactory.setIntoAQuestion("wrongAnswer2", randomized[i][3]);
			triviaFactory.setIntoAQuestion("wrongAnswer3", randomized[i][4]);
			triviaFactory.setIntoAQuestion("hint", randomized[i][5]);
			triviaFactory.clearAndSetToQuestions();
		}
		
		$location.path('/trivia');
	};
});