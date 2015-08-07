app.factory("triviaQuestionFactory", function(){
	var questions = [];
	var question = [];
	
	return{
		setIntoAQuestion: function(key, value) {
			return question[key] = value;
		},
		getAQuestion: function(arrayNumber) {
			return questions[arrayNumber];
		},
		clearAndSetToQuestions:function() {
			questions.push(question);
			question = [];
			return;
		}
	};
});