<?php 
	require_once("../../controllers/helpers/storedUserInfo.php"); //session_start is in here already
	require_once("../../controllers/helpers/storedSearchInfo.php");
	require_once("../../../resources/templates/header.php");
	docheaderWithJqueryLibraries("Open Content Creator - Home", "../../../public/css/style.css", "../../../public/img/myicon.ico", array("../../../resources/library/jquery.leanModal.min.js", "../../../public/js/modaltrigger.js"));
?>
	</head>
	<body>
	<?php
		var_dump($userObj); 
		var_dump($searchObj);
	?>
<?php 
	require_once("../../../resources/templates/footer.php");
	viewsFooter("../../../public/img/layout/occlogo_bottom.png");
?>