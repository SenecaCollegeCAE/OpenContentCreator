var app = angular.module('triviaActivity', ['ngRoute', 'ngAnimate']);

app.config(['$routeProvider', function($routeProvider) {
	$routeProvider.when('/home', {
		title: 'Home',
		templateUrl: 'home.php',
		controller: 'homeController'
	}).
	when('/trivia', {
		title: 'Trivia',
		templateUrl: 'triviastart.php',
		controller: 'triviaController'
	}).
	when('/triviaSecond', {
		title: 'Trivia',
		templateUrl: 'triviasecond.php',
		controller: 'triviaSecondController'
	}).
	otherwise({
		redirectTo: '/home'
	});
}]);