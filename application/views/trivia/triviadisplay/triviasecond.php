<?php
	session_start();
	require_once("../../../../application/controllers/helpers/storedActivityInfo.php");
?>
<br />
<div class="triviamainbox"><!--  trivia second -->
	<div class="questionbox" ng-init="loadQuestion()">
		<h2 ng-show="!questionActive" class="questionnumberdone">Congratulations! You have completed the trivia activity.</h2>
		<button id="startTrivia" ng-show="!questionActive" ng-click="playAgain()">Play Again</button>
		<h2 ng-show="questionActive" class="questionnumber">Question Number: {{questionNumber}}</h2>
		<h3 ng-show="questionActive">{{question}}</h3>
	</div>
	<!-- User choices -->
	<ul>
		<li class="horizontal_li" ng-repeat="option in options track by $index">
			<label class="button" ng-click="clickDisabled || answerQuestion(option)" ng-disabled="clickDisabled">{{option}}</label>
			<br /><br />
		</li>
	</ul>
	<!-- End of User choices -->
	<!-- Lifelines -->
	<div ng-show="questionActive" class="lifelines">
	
	</div>
	<!-- End of Lifelines -->
	<br /><br />
	<div class="table">
		<div class="score">
			<span ng-show="questionActive">Score: {{score}} {{scoreType}}</span>
			<span ng-show="!questionActive">Your final score is: {{score}} {{scoreType}}</span>
		</div>
		<div class="feedback" ng-show="!answerMode">
			<span ng-show="correctAns">That is correct!</span>
			<span ng-show="!correctAns">Sorry, that is an incorrect answer.</span>
		</div>
	</div>
</div>