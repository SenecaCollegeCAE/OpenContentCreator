app.controller('homeController', function($scope, $rootScope, $location, triviaQuestionFactory) {
	if(angular.element("main").hasClass('slider'))
		$scope.animating = true;
	else
		$scope.animating = false;
	
	$rootScope.questionNumber = 0;
	
	$scope.getScoreType = function(sType) {
		if(sType == "dollars" || sType == "points")
			$rootScope.score = 0;
		else 
			$rootScope.score = 1;
		
		$rootScope.scoreType = sType;
	};
	
	$scope.getLifelines = function(lifeLine5050, lifeLineHint, lifeLineAudience) {
		triviaQuestionFactory.setIntoALifeline("lifeLine5050", lifeLine5050);
		triviaQuestionFactory.clearAndSetToLifelines();
		triviaQuestionFactory.setIntoALifeline("lifeLineHint", lifeLineHint);
		triviaQuestionFactory.clearAndSetToLifelines();
		triviaQuestionFactory.setIntoALifeline("lifeLineAudience", lifeLineAudience);
		triviaQuestionFactory.clearAndSetToLifelines();
		
		//get the lifelines
		var ll = triviaQuestionFactory.getLifeline();
		$rootScope.lifeLine5050 = ll[0].lifeLine5050;
		$rootScope.lifeLineHint = ll[1].lifeLineHint;
		$rootScope.lifeLineAudience = ll[2].lifeLineAudience;
	};
	
	$scope.startTrivia = function(randomized, sType) {		
		for(var i = 0; i < randomized.length; i++) {
			triviaQuestionFactory.setIntoAQuestion("question", randomized[i][0]);
			triviaQuestionFactory.setIntoAQuestion("correctAnswer", randomized[i][1]);
			triviaQuestionFactory.setIntoAQuestion("wrongAnswer1", randomized[i][2]);
			triviaQuestionFactory.setIntoAQuestion("wrongAnswer2", randomized[i][3]);
			triviaQuestionFactory.setIntoAQuestion("wrongAnswer3", randomized[i][4]);
			triviaQuestionFactory.setIntoAQuestion("hint", randomized[i][5]);
			triviaQuestionFactory.clearAndSetToQuestions();
		}
	
		$location.path('/trivia');
	};
});