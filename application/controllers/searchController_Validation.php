<?php
	$searchError1 = $searchError2 = false;
	
	if(isset($_POST['searchActivity']) && $_POST['searchActivity'] != "") {
		$search = trim(filter_var($_POST['searchActivity']), FILTER_SANITIZE_STRING);

		require_once("../../resources/models/Search.php");
		$searchResults = new Search();
		
		if(!$searchResults->getActivityNotLoggedIn($search)) {
			$searchError2 = true;
		}
	}
	else {
		$searchError1 = true;
	}
?>