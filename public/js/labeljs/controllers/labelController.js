app.controller('labelController', function($scope, $rootScope, $location, $window, labelDraggingFactory) {
	$scope.animating = true;
	
	$scope.init = function() {		
		labelDraggingFactory.loadLabelDragging($scope);
	};
	
	$scope.reloadActivity = function() {
		$window.location.reload(true);
	};
});