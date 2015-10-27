<?php
	$searchError2 = false;

	if(isset($_GET['search']) && $_GET['search'] != "") {
		$searchValue = trim(filter_var($_GET['search'], FILTER_SANITIZE_STRING));
		
		require_once("../../../resources/models/Search.php"); //call the search model class
		$publicSearch = new Search();
		
		if($publicSearch->getActivityLoggedIn($searchValue)) {
			$searchResults = $publicSearch->printResultsAndCopy($userInfoArray[0]);
		}
		else {
			$searchError2 = true;
		}
		
	}
	else {
		header("Location: ../activity.php");
		exit;
	}
?>