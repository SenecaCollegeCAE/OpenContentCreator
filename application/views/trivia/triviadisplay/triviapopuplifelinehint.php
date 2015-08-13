<html ng-app="triviaPopUpHint">
<head>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="../../../../resources/library/angular.min.js"></script>
  	<script src="../../../../public/js/triviajs/controllers/triviaPopUpHintController.js"></script>
</head>
<body ng-controller="triviaPopUpHintController" ng-focus="focus()">
	<h3>Hint is: </h3>
	<div>
		<p>&ndash; {{hint}}</p>
	</div>
</body>
</html>