var triviaPopUp = angular.module('triviaPopUp5050', []);

triviaPopUp.controller('triviaPopUp5050Controller', function($scope, $window) {
	$scope.answers = window.opener.possibleAnswers;
	
	$window.focus = function() {
		console.log("focus");
	};
});

