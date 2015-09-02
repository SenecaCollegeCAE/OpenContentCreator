<?php 
	session_start();
	require_once("../../../../application/controllers/helpers/storedActivityInfo.php");
?>
<!DOCTYPE html>
	<html lang="en-US" ng-app="labelActivity">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="../../../../public/css/labeldisplay.css" />
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
  		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  		<script src="../../../../resources/library/angular.min.js"></script>
		<script src="../../../../resources/library/angular-route.min.js"></script>
		<script src="../../../../resources/library/angular-animate.min.js"></script>
		<script src="../../../../resources/library/kinetic-v5.0.1.min.js"></script>
		<script src="../../../../public/js/labeljs/app.js"></script>
		<script src="../../../../public/js/labeljs/controllers/homeController.js"></script>
		<script src="../../../../public/js/labeljs/controllers/labelController.js"></script>
		<script src="../../../../public/js/labeldragging.php"></script>
	</head>
	<body>
		<div class="labelbackground" style="background-color: <?php echo $activityObj[4]; ?>;">
		<header>
		
		</header>
		<br /><br />
		<main ng-view ng-class="{'notSlider' : !animating, 'slider' : animating}"></main>
		<br /><br />
		<footer>
			<div class="footer" ng-include="'footer.php'"></div>
		</footer>
		</div>
	</body>
	</html>