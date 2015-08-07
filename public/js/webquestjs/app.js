var app = angular.module('webquestActivity', ['ngRoute', 'ngAnimate']);

app.config(['$routeProvider', function($routeProvider) {
		$routeProvider.when('/home', {
			title: 'Home',
			templateUrl: 'home.php',
			controller: 'homeController'
		}).
		when('/outcomes', {
			title: 'Outcomes',
			templateUrl: 'outcomes.php',
			controller: 'outcomesController'
		}).
		when('/overview', {
			title: 'Overview',
			templateUrl: 'overview.php',
			controller: 'overviewController'
		}).
		when('/links', {
			title: 'Links',
			templateUrl: 'links.php',
			controller: 'linksController'
		}).
		when('/evaluation', {
			title: 'Evaluation',
			templateUrl: 'evaluation.php',
			controller: 'evaluationController'
		}).
		otherwise({
			redirectTo: '/home'
		});
		
}]);