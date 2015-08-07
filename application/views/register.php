<?php
	require_once("../controllers/registerController_Validation.php"); 
	require_once("../../resources/templates/header.php");
	docheader("Open Content Creator - Register", "../../public/css/style.css", "../../public/img/myicon.ico");
?>
	</head>
	<body>
		<div id="logoplacement">
			<a href="../../index.php"><img src="../../public/img/layout/occlogo.png" border="0" /></a>
		</div>
		<div class="registerform">
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
				<fieldset class="registerform">
					<legend class="registerform">Register</legend>
					<p>Username: <span class="registerform"><input type="text" name="regUname" size="40" maxlength="40" value="<?php if(isset($_POST['regUname'])) { echo $_POST['regUname']; } ?>" <?php if(($unameError1 == true) || ($unameError2 == true)) { echo "autofocus"; } ?>/></span>
					<?php 
						if(isset($_POST['regUname'])) {
							if($unameError1)
								echo '<div class="registererrormsg">*Username can only contain letters, numbers and underscore</div>';
							else if($unameError2)
								echo '<div class="registererrormsg">*Username cannot be less than 5 characters</div>';
							else if($unameError3)
								echo '<div class="registererrormsg">*Username already exists</div>';
						}
					?>
					<p style="margin-top: 10px;">Password: <span style="padding-left: 58px;"><input type="password" name="regPassword" size="40" maxlength="40" <?php if(($passwordError1 == true) || ($passwordError2 == true)) { echo "autofocus"; } ?>/></span></p>
					<?php 
						if(isset($_POST['regPassword'])) {
							if($passwordError1)
								echo '<div class="registererrormsg">*Password cannot be less than 7 characters</div>';
							else if($passwordError2)
								echo '<div class="registererrormsg">*Passwords do not match each other</div>';
						}
					?>
					<p style="margin-top: 10px;">Confirm Password: <span style="padding-left: 9px;"><input type="password" name="regCPassword" size="40" maxlength="40" <?php if(($cPasswordError1 == true)) { echo "autofocus"; } ?>/></span></p>
					<?php 
						if(isset($_POST['regCPassword'])) {
							if($cPasswordError1)
								echo '<div class="registererrormsg">*Password cannot be empty</div>'; 
						}
					?>
					<p style="margin-top: 10px;">Email: <span style="padding-left: 82px;"><input type="email" name="regEmail" size="40" maxlength="50" value="<?php if(isset($_POST['regEmail'])) { echo $_POST['regEmail']; } ?>" <?php if(($emailError1 == true)) { echo "autofocus"; } ?>/></span></p>
					<?php 
						if(isset($_POST['regEmail'])) {
							if($emailError1)
								echo '<div class="registererrormsg">*Email is not valid format</div>';
							else if($emailError2)
								echo '<div class="registererrormsg">*Email already exist</div>';
						}
					?>
					<br />
					<?php 
						echo "<div style='margin-left: 124px;'>";
						echo recaptcha_get_html($publickey);
						echo "</div>";
						
						if($captchaError1)
							echo '<br /><div class="registererrormsg">*Field does not match image above</div>';
					?>
					<br /><br />
					<div>
		    			<input style="margin-left: 166px;" type="submit" name="btnregister" value="Register User">
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