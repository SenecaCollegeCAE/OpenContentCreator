<?php
	//retrieve the login user object
	require_once("../../../resources/models/User.php");
	session_start();
	
	//checks if there is a User session and the cookie has not expired
	if(!isset($_SESSION['User']) || $_SESSION['User'] == null || empty($_COOKIE['PHPSESSID']) || $_COOKIE['PHPSESSID'] == null) {
		header("Location: ../../../index.php");
		exit;
	}
	
	$userObj = unserialize($_SESSION['User']); //Session obj is a class object
	$userInfoArray = $userObj->getUserInfoFromSession();
?>