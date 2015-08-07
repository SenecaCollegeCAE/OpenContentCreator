<?php
	function unsetSessions() {
		if(isset($_SESSION['webquestLinks']))
			unset($_SESSION['webquestLinks']);
		
		if(isset($_SESSION['webquestTasks']))
			unset($_SESSION['webquestTasks']);
		
		if(isset($_SESSION['webquestQuestions']))
			unset($_SESSION['webquestQuestions']);
	}
	
	function clearAndSetLinks($links) {
		if(isset($_SESSION['webquestLinks'])) 
			unset($_SESSION['webquestLinks']);
		
		$_SESSION['webquestLinks'] = serialize($links);
	}
	
	function clearAndSetTasks($tasks) {
		if(isset($_SESSION['webquestTasks']))
			unset($_SESSION['webquestTasks']);
		
		$_SESSION['webquestTasks'] = serialize($tasks);
	}
	
	function clearAndSetQuestions($questions) {
		if(isset($_SESSION['webquestQuestions']))
			unset($_SESSION['webquestQuestions']);
	
		$_SESSION['webquestQuestions'] = serialize($questions);
	}
	
	function setImageName($image) {
		$_SESSION['webquestImage'] = serialize($image);
	}
	
	function getImageName() {
		$imageName = "";
		
		if(isset($_SESSION['webquestImage'])) {
			$imageName = unserialize($_SESSION['webquestImage']);
			unsetImageSession();
		}
		
		return $imageName;
	}
	
	function unsetImageSession() {
		unset($_SESSION['webquestImage']);
	}
?>