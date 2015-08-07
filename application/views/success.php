<?php
	require_once("../../resources/templates/header.php");
	docheader("Open Content Creator - Register", "../../public/css/style.css", "../../public/img/myicon.ico");
?>
	</head>
	<body>
		<div id="logoplacement">
		    <a href="index.php"><img src="../../public/img/layout/occlogo.png" border="0" /></a><!-- Logo picture -->
		</div>
		<div style="padding-top: 100px; text-align: center;">
			<h2>
				<?php 
					if(isset($_GET['status']) && $_GET['status'] == 'registered')
						echo "User was successfully registered.";
					else if(isset($_GET['status']) && $_GET['status'] == 'resetedPassword')
						echo "Password was successfully reset.";
				?>
			</h2>		
		    <p>This page will automatically be redirected in: <span id="timer" style="color: #FF0000; display: inline-block; font-weight: bold;"></span></p>
		    <script src="../../public/js/redirect.js"></script>
		    <br />
		</div>
<?php 
	require_once("../../resources/templates/footer.php");
	viewsFooter("../../public/img/layout/occlogo_bottom.png");	
?>