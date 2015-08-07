<?php	
	$oldPasswordError1 = $oldPasswordError2 = false;
	$newPasswordError1 = $newPasswordError2 = false;
	$repeatPasswordError1 = false;
	
	$errors = [];

	if(!empty($_POST)) {		
		 if(strlen($_POST['oldPass']) < 7) { //if old password is less than 7 characters
		 	$oldPasswordError1 = true;
		 	$errors['oldPassError1'] = $oldPasswordError1;
		 }
		 	
		 if(crypt($_POST['oldPass'], $_POST['cryptPass']) != $_POST['cryptPass']) { //if original password typed doesn't match the one in database
		 	$oldPasswordError2 = true;
		 	$errors['oldPassError2'] = $oldPasswordError2;
		 }
		 
		 if(strlen($_POST['newPass']) < 7) { //if new password is less than 7 characters
		 	$newPasswordError1 = true;
		 	$errors['newPassError1'] = $newPasswordError1;
		 }
		 
		 if($_POST['newPass'] != $_POST['repeatPass']) { //if new / repeat password doesn't match each other
		 	$newPasswordError2 = true;
		 	$errors['newPassError2'] = $newPasswordError2;
		 }	
		 	
		 if(strlen($_POST['repeatPass']) < 7) { //if repeated password is less than 7 characters
		 	$repeatPasswordError1 = true;
		 	$errors['repeatPassError1'] = $repeatPasswordError1;
		 }
		 //End of Form validation
		 
		 if(!$oldPasswordError1 && !$oldPasswordError2 && !$newPasswordError1 && !$newPasswordError2 && !$repeatPasswordError1) {
		 	$finalPassword = trim(filter_var($_POST['newPass']), FILTER_SANITIZE_STRING);
		 	
		 	require_once("../../../resources/models/User.php"); //call the user model
		 	$changePasswordUser = new User();
		 	$changePasswordUser->changePasswordWithNewPassword($_POST['userId'], $_POST['userName'], $finalPassword);
		 	
		 	$_POST = []; //clear the $_POST
		 	echo json_encode("");
		 }
		 else {
		 	$_POST = [];
		 	echo json_encode($errors);
		 }
	}
?>