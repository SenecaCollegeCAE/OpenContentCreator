<?php
	session_start();
	require_once("../controllers/helpers/storedActivityInfo.php");
	require_once("../controllers/displayActivityController.php"); 
	require_once("../../resources/templates/header.php");
	docheader("Open Content Creator - Search Activity", "../../public/css/style.css", "../../public/img/myicon.ico");
?>
	</head>
	<body>
		<div id="logoplacement">
			<a href="../../index.php"><img src="../../public/img/layout/occlogo.png" border="0" /></a>
		</div>
		<br />
		<div class="webquestactivitiesmaintable">
			<h2><?php 
				if(isset($finalActivityObj[15]) && is_string($finalActivityObj[15])) {
					if($finalActivityObj[15] == 'webq')	 
						echo 'Webquest';
				}
				else if(isset($finalActivityObj[20]) && is_string($finalActivityObj[20])) {
					if($finalActivityObj[20] == 'trivia')
						echo 'Trivia';
				}
				else if(isset($finalActivityObj[14]) && is_string($finalActivityObj[14])) {
					if($finalActivityObj[14] == 'label')
						echo 'Label';
				}
			?></h2>
			<div class="activityLeftTextFormat"></div>
			<div class="activityRightCopying"></div>
			<?php
				if(isset($finalActivityObj[15]) && is_string($finalActivityObj[15])) {
					if($finalActivityObj[15] == 'webq')	  
						echo '<iframe class="iframePresentation" src="./webquest/webquestdisplay/index.php" seamless="seamless" scrolling="no">Your Browser does not support Iframe</iframe>';
				}
				else if(isset($finalActivityObj[20]) && is_string($finalActivityObj[20])) {
					if($finalActivityObj[20] == 'trivia')
						echo '<iframe class="iframePresentation2" src="./trivia/triviadisplay/index.php" seamless="seamless" scrolling="no">Your Browser does not support Iframe</iframe>';
				}
				else if(isset($finalActivityObj[14]) && is_string($finalActivityObj[14])) {
					if($finalActivityObj[14] == 'label')
						echo '<iframe class="iframePresentation2" src="./labelActivity/labeldisplay/index.php" seamless="seamless" scrolling="no">Your Browser does not support Iframe</iframe>';
				}
			?>
			<br /><br />
		</div>
		<br /><br /><br /><hr /><br /><div style="text-align: center"><a href="../../index.php">Return to homepage</a></div>
<?php
	require_once("../../resources/templates/footer.php");
	viewsFooter("../../public/img/layout/occlogo_bottom.png");
?>