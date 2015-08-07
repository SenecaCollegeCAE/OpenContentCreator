<?php
	session_start();
	require_once("../../../../application/controllers/helpers/storedActivityInfo.php");
?>
<br />
<div class="triviamainbox"><!--  trivia start -->
	<div class="questionbox" ng-init="loadQuestion()">
		<h2 class="questionnumber">Question Number: {{questionNumber}}</h2>
		<h3>{{question}}</h3>
	</div>
	<!-- User choices -->
	<ul>
		<li class="horizontal_li" ng-repeat="option in options" ng-animate="'animate'">
			<label class="button" ng-click="answerQuestion(option)">{{option}}</label>
			<br /><br />
		</li>
	</ul>
	<!-- End of User choices -->
	<!-- Lifelines -->
	<div class="lifelines">
	
	</div>
	<!-- End of Lifelines -->
	<br />
	<div ng-show="!answerMode">
		<span ng-show="correctAns">That is correct!</span>
		<span ng-show="!correctAns">Sorry, that is an incorrect answer.</span>
	</div>
</div>