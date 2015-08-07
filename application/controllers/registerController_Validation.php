<?php
	if(isset($_GET['status']) && $_GET['status'] == "success") {
		header("Location: ../views/success.php?status=registered");
		exit;
	}
	
	require_once("../../resources/library/recaptcha/recaptchalib.php");
	$publickey = "6LeX8OsSAAAAAIYrtC2y1MmT0NlJV2Op4_OPf97A";
	
	//"Global" variables to tell if an input field has any type of error
	$unameError1 = $unameError2 = $unameError3 = false;
	$passwordError1 = $passwordError2 = false;
	$cPasswordError1 = false;
	$emailError1 = $emailError2 = false;
	$captchaError1 = false;

	if(!empty($_POST)) {
		
		//Form validation
		$username = trim(filter_var($_POST['regUname'], FILTER_SANITIZE_STRING));
		$password = trim(filter_var($_POST['regPassword'], FILTER_SANITIZE_STRING));
		$cPassword = trim(filter_var($_POST['regCPassword'], FILTER_SANITIZE_STRING));
		$email = trim(filter_var($_POST['regEmail'], FILTER_VALIDATE_EMAIL));
	
		if(!preg_match("/[a-z0-9_]+$/i", $username)) { //if username does not contain lowercase letters, number or underscore
			$unameError1 = true;
		}
		
		if(strlen($username) < 5) { //if username is less than 5 characters 
			$unameError2 = true;
		}
		
		if(strlen($password) < 7) //if password is less than 7 characters
		{
			$passwordError1 = true;
		}
		
		if($cPassword == "")
		{
			$cPasswordError1 = true;
		}
		
 		if($password != $cPassword) //if password doesn't match the confirm password
	    {
	    	$passwordError2 = true;
	    }
	    
	    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) //if email is not the correct format
	    {
	    	$emailError1 = true;
	    }
	    
	    //checks for captcha
	    $privatekey = "6LeX8OsSAAAAAPlwgNWs-opPhne6M0NAbcEtdEqn";
	    $resp = recaptcha_check_answer($privatekey, $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
	    
	    if(!$resp->is_valid) { //if captcha does not match the image
	    	$captchaError1 = true;
	    }
		//End of Form validation
		
		if(!$unameError1 && !$unameError2 && !$passwordError1 && !$passwordError2 && !$cPasswordError1 && !$emailError1 && !$captchaError1) {	
			require_once("../../resources/models/User.php"); //call the user model class
			$registerUser = new User(); 
			$promise = $registerUser->registerUserToServer($username, $password, $email);
		
			if($promise == "success") {
				header("Location: ../views/register.php?status=success");
				exit;
			}
			else if($promise == "registeredWithoutEmailSent") {
				header("Location: ../../index.php");
				exit;
			}
			else if($promise == "duplicateUsername") {
				$unameError3 = true;
			}
			else {
				$emailError2 = true;
			}
		}
	}
?>