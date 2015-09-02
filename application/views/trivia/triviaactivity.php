<?php
	require_once("../../controllers/helpers/storedUserInfo.php");
	require_once("../../controllers/viewTriviaController.php");
	require_once("../../../resources/templates/header.php");
	docheaderWithJqueryLibraries("Open Content Creator - Trivia Activity", "../../../public/css/style.css", "../../../public/img/myicon.ico", array("../../../resources/library/jquery.leanModal.min.js", "../../../public/js/modaltrigger.js"));
?>
	</head>
	<body>
		<?php			
			//Top Navigation bar 
			require_once("../../../resources/templates/navigation.php");
			navigationBody($userInfoArray[1], "../activityMain/");
			require_once("../../../resources/templates/changepassword.php");
			changePassword($userInfoArray[0], $userInfoArray[1], $userInfoArray[3]);
			require_once("../../../resources/templates/help.php");
			helpMenu();
			//End of Top Navigation bar
		?>
		<div class="triviaactivitiesmaintable">
			<h2>Trivia</h2>
			<div class="activityLeftTextFormat">
				<a href="./triviatext.php" target="_blank">View activity in plain text format</a>
			</div>
			<div class="activityRightCopying">
				<?php 
					if($userCreator)
						echo "<a href='./label.php?activityNumber=" . $triviaObj[0] . "'>Edit this activity</a>";
				?>
			</div>
			<iframe class="iframePresentation2" src="../trivia/triviadisplay/index.php" seamless="seamless" scrolling="no">Your Browser does not support Iframes.</iframe>
			<br /><br />
			<?php //var_dump($triviaObj, $userObj); ?>
		</div>
		<br /><br /><br /><hr /><br /><div style="text-align: center"><a href="../activityMain/activity.php">Return to homepage</a></div>
<?php 
	require_once("../../../resources/templates/footer.php");
	viewsFooter("../../../public/img/layout/occlogo_bottom.png");
?>