<?php
	session_start();
	require_once("../../../../application/controllers/helpers/storedActivityInfo.php");
?>
<br />
<div class="triviamainbox"><!--  trivia start -->
	<div class="questionbox" ng-init="loadQuestion()">
		<h2 ng-show="!questionActive" class="questionnumberdone">Congratulations! You have completed the trivia activity.</h2>
		<button ng-show="!questionActive" id="startTrivia" ng-click="playAgain()">Play Again</button>
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
		<img src="../../../../public/img/layout/lifeline5050.png" width="40" height="40" alt="lifeline5050" ng-click="chooseLifeLine5050()" class="iconClick"/><span class="lifelinefont"> x {{lifeLine5050}}</span>
		<div class="lifelinespacer"></div>
		<img src="../../../../public/img/layout/lifelineHint.png" width="40" height="40" alt="lifelineHint" ng-click="" class="iconClick"/><span class="lifelinefont"> x {{lifeLineHint}}</span>
		<div class="lifelinespacer"></div>
		<img src="../../../../public/img/layout/lifelineAudience.png" width="40" height="40" alt="lifelineAudience" ng-click="" class="iconClick"/><span class="lifelinefont"> x {{lifeLineAudience}}</span>
	</div>
	<!-- End of Lifelines -->
	<br /><br /><br />
	<div class="table">
		<div class="score">
			<span ng-show="questionActive">Score: {{score}} {{scoreType}}</span>
			<span ng-show="!questionActive">Your final score is: <br />{{score}} {{scoreType}}</span>
		</div>
		<div class="feedback" ng-show="!answerMode">
			<span ng-show="correctAns">That is correct!</span>
			<span ng-show="!correctAns">Sorry, that is an incorrect answer.</span>
		</div>
	</div>
</div>