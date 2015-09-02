<?php
	function setImageName($image) {
		$_SESSION['labelImage'] = serialize($image);
	}

	function getImageName() {
		$imageName = "";
	
		if(isset($_SESSION['labelImage'])) {
			$imageName = unserialize($_SESSION['labelImage']);
			unsetImageSession();
		}
	
		return $imageName;
	}
	
	function unsetImageSession() {
		unset($_SESSION['labelImage']);
	}
?>