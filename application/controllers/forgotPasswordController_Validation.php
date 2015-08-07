<?php
	if(isset($_GET['status']) && $_GET['status'] == "success") {
		header("Location: ../views/success.php?status=resetedPassword");
		exit;
	}
		
	//"Global" variables to tell if an input field has any type of error
	$emailError1 = $emailError2 = false;
	
	if(!empty($_POST)) {
		
		//Form validation
		$email = trim(filter_var($_POST['forgotEmail'], FILTER_VALIDATE_EMAIL));
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) //if email is not the correct format
    	{
    		$emailError1 = true;
    	}
    	else {
    		require_once("../../resources/models/User.php"); //call the user model
    		$forgotPasswordUser = new User();
    		$promise = $forgotPasswordUser->getEmailFromServer($email);
    		    	
    		if($promise == "success") {
    			header("Location: ../views/forgotpassword.php?status=success");
    			exit;
    		}
    		else if($promise == "newPasswordWithoutEmailSent") {
    			header("Location: ../../index.php");
    			exit; 
    		}
    		else {
    			$emailError2 = true;
    			//uncomment below to see the password 
    			//header("Location: ../crap.php?pass=".$promise);
    			//exit;
    		}
    	}
	} //if(!empty($_POST))
?>