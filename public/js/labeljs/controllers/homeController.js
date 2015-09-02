app.controller('homeController', function($scope, $rootScope, $location) {
	if(angular.element("main").hasClass('slider'))
		$scope.animating = true;
	else
		$scope.animating = false;
	
	$scope.startLabel = function() {
		$location.path('/label');
	};
});