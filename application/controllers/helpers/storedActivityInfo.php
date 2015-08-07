<?php		
	//check if there is an Activity session
	if(isset($_SESSION['activity'])) {
		$activityObj = unserialize($_SESSION['activity']);
	} 
?>