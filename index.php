<?php
	require_once("./application/controllers/indexLoginController_Validation.php");
	require_once("/resources/templates/header.php");
	docheader("Open Content Creator - Login", "./public/css/style.css", "./public/img/myicon.ico");
?>
	</head> <!-- Put the closing head tag outside because there might be different javascript per page -->
	<body>
		<div id="loginsplash">
			<div id="loginboxpos">
	            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
	                <h2 class="logintitle">Login</h2>
	                <p class="loginleading">Username:</p>
	                <input type="text" name="uname" size="17" maxlength="40" />
	                <p class="loginleading">Password:</p>
	                <input type="password" name="pword" size="17" maxlength="40" />
	                <p class="loginleading"></p>
	                <input type="submit" name="btnlogin" value="Login">
	            </form>
        	</div>
		</div>
<?php
	if(isset($_GET['status'])) {
		print <<<EOF
        <p class="loginerror">*Incorrect username or password entered</p>
EOF;
	}
	
	require_once("/resources/templates/footer.php");
	footer("./public/img/layout/occlogo_bottom.png");	
?>