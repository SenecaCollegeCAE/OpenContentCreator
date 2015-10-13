<?php
	$searchError1 = $searchError2 = false;
	
	if(isset($_POST['searchActivity']) && $_POST['searchActivity'] != "") {
		$searchValue = trim(filter_var($_POST['searchActivity']), FILTER_SANITIZE_STRING);

		require_once("../../resources/models/Search.php");
		$search = new Search();
		
		if(!$search->getActivityNotLoggedIn($searchValue)) {
			$searchError2 = true;
		}
		
		$searchResults = $search->printResults();
	}
	else {
		$searchError1 = true;
	}
?>