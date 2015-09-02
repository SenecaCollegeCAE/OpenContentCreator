var app = angular.module('labelActivity', ['ngRoute', 'ngAnimate']);

app.config(['$routeProvider', function($routeProvider) {
	$routeProvider.when('/home', {
		title: 'Home',
		templateUrl: 'home.php',
		controller: 'homeController'
	}).
	when('/label', {
		title: 'Label',
		templateUrl: 'labelstart.php',
		controller: 'labelController'
	}).
	otherwise({
		redirectTo: '/home'
	});
}]);