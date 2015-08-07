<?php
	//check if there is a Search session
	if(!isset($_SESSION['loggedInSearch'])) {
		header("Location: ./activity.php");
		exit;
	}

	$searchObj = unserialize($_SESSION['loggedInSearch']); //Session obj is a class object
	
	//Set variables to display the search result first
	
	//After setting variables destroy the search session
	if(isset($_SESSION['loggedInSearch'])) {
		$searchObj->resetInfoAfterSearching(); //reset everything in the Search class back to default
		unset($_SESSION['loggedInSearch']);
	}
	 
?>