<?php
	if(!empty($_POST)) {
		
		//Form validation
		$username = trim(filter_var($_POST['uname'], FILTER_SANITIZE_STRING));
		$password = trim(filter_var($_POST['pword'], FILTER_SANITIZE_STRING));
		
		if(strlen($password) < 7) {
			header("Location: index.php?status=error");
			exit;
		}
		//End of Form validation
		
		require_once("/resources/models/User.php"); //call the user model
		$loginUser = new User();
		$promise = $loginUser->getUserFromServer($username, $password);
		
		if($promise) {
			session_start();
			setcookie("PHPSESSID", session_id(), time() + 3600, "/"); //set the session to 1(3600 seconds) hour and create a cookie name PHPSESSID
		
			$_SESSION['User'] = serialize($loginUser); //Store the user info into a session object.
			
			header("Location: ./application/views/activityMain/activity.php");
			exit;
		}
		else {
			header("Location: index.php?status=error");
			exit;
		}
	}
?>