app.controller('linksController', function($scope) {
	$scope.animating = true;
	
	$scope.link = 1;
	
	$scope.changeLink = function(linkNumber) {
		$scope.link = linkNumber;
	};
});