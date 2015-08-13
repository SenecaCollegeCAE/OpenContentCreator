app.factory("triviaRandomizeFactory", function() {
	var random = [];
	var tempArray = [];
	var tempNumber = 4;
	
	return {
		getAnswersAndRandomize: function(wAnswer1, wAnswer2, wAnswer3, cAnswer) {
			tempArray.push(wAnswer1, wAnswer2, wAnswer3, cAnswer);
			
			for(var i = 0; i < 4; i++) {
				var randomNumber = Math.floor(Math.random() * tempNumber); //get a random number 0 - 3
				var tempItem = tempArray[randomNumber]; //get the element from the random number
						
				tempArray.splice(randomNumber, 1);

				random.push(tempItem);
				tempNumber--;
			}

			return random;
		},
		clearAndReset: function() {
			random = [];
			tempArray = [];
			tempNumber = 4;
			return;
		},
		getLifeline5050Values: function(wAnswer1, wAnswer2, wAnswer3, cAnswer, origAnswers) {
			var wrongAnswers = [];
			var possibleValues = [];
			
			wrongAnswers.push(wAnswer1, wAnswer2, wAnswer3);
			var randomSpot = Math.floor(Math.random() * 3);
			
			for(var i = 0; i < 4; i++) {
				if(wrongAnswers[randomSpot] === origAnswers[i]) {
					possibleValues.push(wrongAnswers[randomSpot]);
				}
				else if(cAnswer === origAnswers[i]) {
					possibleValues.push(cAnswer);
				}
			}
			
			return possibleValues;
		}
	};
});