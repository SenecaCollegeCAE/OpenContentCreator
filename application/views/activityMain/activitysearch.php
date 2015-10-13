<?php 
	require_once("../../controllers/helpers/storedUserInfo.php"); //session_start is in here already
	require_once("../../controllers/searchControllerLoggedin.php");
	require_once("../../../resources/templates/header.php");
	docheaderWithJqueryLibraries("Open Content Creator - Home", "../../../public/css/style.css", "../../../public/img/myicon.ico", array("../../../resources/library/jquery.leanModal.min.js", "../../../public/js/modaltrigger.js"));
?>
	</head>
	<body>
	<?php	
		//Top Navigation bar
		require_once("../../../resources/templates/navigation.php");
		navigationBody($userInfoArray[1], "./");
		require_once("../../../resources/templates/changepassword.php");
		changePassword($userInfoArray[0], $userInfoArray[1], $userInfoArray[3]);
		require_once("../../../resources/templates/help.php");
		helpMenu();
		//End of Top Navigation bar
	?>
	<div class="searchboxloggedin">
		<fieldset class="searchboxloggedin">
			<legend class="searchbox">Search Activity</legend>
			<?php
				echo '<h3>Search for &quot;'. $searchValue . '&quot; Result:</h3><br />';
			
				if(!$searchError2)				
					echo $searchResults;
				else 
					echo "<h2>Search did not return any results.</h2>";
			?>
		</fieldset>
	</div>
	<br /><br /><hr /><br /><div style="text-align: center"><a href="../activityMain/activity.php">Return to homepage</a></div>
<?php 
	require_once("../../../resources/templates/footer.php");
	viewsFooter("../../../public/img/layout/occlogo_bottom.png");
?>