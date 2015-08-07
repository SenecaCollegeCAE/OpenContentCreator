<?php
	function setImageName($image) {
		$_SESSION['triviaImage'] = serialize($image);
	}

	function getImageName() {
		$imageName = "";
	
		if(isset($_SESSION['triviaImage'])) {
			$imageName = unserialize($_SESSION['triviaImage']);
			unsetImageSession();
		}
	
		return $imageName;
	}
	
	function unsetImageSession() {
		unset($_SESSION['triviaImage']);
	}
?>