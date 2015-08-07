app.controller('homeController', function($scope) {
	if(angular.element("main").hasClass('slider'))
		$scope.animating = true;
	else
		$scope.animating = false;
});