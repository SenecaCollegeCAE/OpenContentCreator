<?php
//used for trivia to randomize the order of questions based on easy, medium and hard
function randomizeQuestions($difficulties, $questions, $correctAnswers, $wrongAnswers1, $wrongAnswers2, $wrongAnswers3, $hints) {
	//Get the total number of questions first
	$totalNumberOfQuestions = 0;

	for($i = 0; $i < 12; $i++) {
		if($questions[$i] != "") {
			$totalNumberOfQuestions++;
		}
	}

	//after total number of questions is discovered, time to order and store them by type
	$easy = [];
	$medium = [];
	$hard = [];

	for($i = 0; $i < $totalNumberOfQuestions; $i++) {
		switch($difficulties[$i]) {
			case "easy":
				$tempEasyArray = [];
				array_push($tempEasyArray, $questions[$i], $correctAnswers[$i], $wrongAnswers1[$i], $wrongAnswers2[$i], $wrongAnswers3[$i], $hints[$i]);
				array_push($easy, $tempEasyArray);
				break;
					
			case "medium":
				$tempMediumArray = [];
				array_push($tempMediumArray, $questions[$i], $correctAnswers[$i], $wrongAnswers1[$i], $wrongAnswers2[$i], $wrongAnswers3[$i], $hints[$i]);
				array_push($medium, $tempMediumArray);
				break;
					
			default:
				$tempHardArray = [];
				array_push($tempHardArray, $questions[$i], $correctAnswers[$i], $wrongAnswers1[$i], $wrongAnswers2[$i], $wrongAnswers3[$i], $hints[$i]);
				array_push($hard, $tempHardArray);
					
		}
	}

	//randomize the questions
	shuffle($easy);
	shuffle($medium);
	shuffle($hard);

	return array_merge($easy, $medium, $hard);
}
?>