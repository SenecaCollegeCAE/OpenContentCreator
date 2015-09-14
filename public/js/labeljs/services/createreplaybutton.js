app.factory("createReplayButtonFactory", function($compile, $window) {	
	return {
		createButton: function(scope) {
			var newElement = $('<button id="startAgain" ng-click="reloadActivity()">Play Again?</button>');
			newElement.insertAfter('#statusText');
			
			$compile(newElement)(scope); //This adds the button element ng-click by dynamically binding after activity is completed
		}
	};
});