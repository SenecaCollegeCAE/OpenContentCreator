<?php 
	require_once("../controllers/forgotPasswordController_Validation.php");
	require_once("../../resources/templates/header.php");
	docheader("Open Content Creator - Forgot Password", "../../public/css/style.css", "../../public/img/myicon.ico");
?>
	</head>
	<body>
		<div id="logoplacement">
			<a href="../../index.php"><img src="../../public/img/layout/occlogo.png" border="0" /></a>
		</div>
		<div class="registerform">
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
				<fieldset class="registerform">
					<legend class="registerform">Forgot Password</legend>
					<p>Email: <span style="padding-left: 56px;"><input type="email" name="forgotEmail" size="40" <?php if(($emailError1 == true) || ($emailError2 == true)) { echo "autofocus"; } ?>/></span></p>
					<?php 
						if(isset($_POST['forgotEmail'])) {
							if($emailError1)
								echo '<div class="forgotpassworderrormsg">*Email is not in valid format</div>';
							else if($emailError2)
								echo '<div class="forgotpassworderrormsg">*Email does not exist</div>';
							
						}
					?>
					<br />
					<div>
						<input style="margin-left: 150px; cursor: pointer; background-color: #404040; color: white; box-shadow:rgba(0,0,0,0.5) 0px 0px 5px;" type="submit" name="btnrecoveremail" value="Recover Password">
					</div>
					<br />
		    			<a href="../../index.php" style="font-weight: bold; margin-left: 152px;">Return to homepage</a>
					<br /><br />
				</fieldset>
			</form>
		</div>
<?php 
	require_once("../../resources/templates/footer.php");
	viewsFooter("../../public/img/layout/occlogo_bottom.png");
?>