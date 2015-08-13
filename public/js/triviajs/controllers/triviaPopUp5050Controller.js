var triviaPopUp = angular.module('triviaPopUp5050', []);

triviaPopUp.controller('triviaPopUp5050Controller', function($scope, $window) {
	console.log(window.opener.possibleAnswers);
	$scope.answers = window.opener.possibleAnswers;
});

