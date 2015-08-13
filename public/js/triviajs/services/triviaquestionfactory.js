app.factory("triviaQuestionFactory", function(){
	var questions = [];
	var question = [];
	var lifeLines = [];
	var lifeLine = [];
	
	return{
		setIntoAQuestion: function(key, value) {
			return question[key] = value;
		},
		getAQuestion: function(arrayNumber) {
			return questions[arrayNumber];
		},
		clearAndSetToQuestions: function() {
			questions.push(question);
			question = [];
			return;
		},
		getTotalQuestions: function() {
			return questions.length;
		},
		setIntoALifeline: function(key, ll) {
			return lifeLine[key] = ll;
		},
		getLifeline: function() {
			return lifeLines;
		},
		clearAndSetToLifelines: function() {
			lifeLines.push(lifeLine);
			lifeLine = [];
			return;
		},
		getCorrectAnswerToQuestion: function(questionNum) {
			return questions[questionNum]['correctAnswer'];
		}
	};
});