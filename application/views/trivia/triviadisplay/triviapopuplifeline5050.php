<html ng-app="triviaPopUp5050">
<head>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="../../../../resources/library/angular.min.js"></script>
  	<script src="../../../../public/js/triviajs/controllers/triviaPopUp5050Controller.js"></script>
</head>
<body ng-controller="triviaPopUp5050Controller" ng-focus="focus()">
	<h3>Answer is either: </h3>
	<div ng-repeat="answer in answers track by $index">
		<p>&ndash; {{answer}}</p>
	</div>
</body>
</html>