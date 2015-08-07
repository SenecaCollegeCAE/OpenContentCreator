<?php 
	require_once("../../resources/models/User.php");
	session_start();
	
	if(isset($_SESSION['User'])) {
		$userObj = unserialize($_SESSION['User']);
		$userObj->resetInfoAfterLoggingOut();//reset everything in the User class back to default
		
		setcookie("PHPSESSID", session_id(), time() - 9200, "/"); //set the cookie to kill the session right away by setting it to a previous day
		session_destroy();
	}
	
	//regardless if there is a session or not when logging out, redirect back to the index page
	header("Location: ../../index.php");
	exit;
?>