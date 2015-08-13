var triviaPopUp = angular.module('triviaPopUpHint', []);

triviaPopUp.controller('triviaPopUpHintController', function($scope, $window) {
	if(window.opener.hint == "")
		$scope.hint = "No hints";
	else
		$scope.hint = window.opener.hint;
	
	$window.focus = function() {
		console.log("focus");
	};
});