<?php
	session_start();
	require_once("../../../../application/controllers/helpers/storedActivityInfo.php");
?>
<br />
<div class="labelmainbox"><!-- home -->
	<h1 class="title"><?php echo $activityObj[1]; ?></h1>
	<article><?php echo $activityObj[2]; ?></article>
	<br />
	<?php 
		if($activityObj[3] != "") {
			echo '<img src="../' . $activityObj[3] . '" />';
			echo '<br /><br /><hr />';
		}
		else 
			echo '<hr />';			
	?>
	<p>Please click the button below to begin this Label activity.</p>
	<br />
	<button id="startLabel" ng-click="startLabel()">Start the Label Activity</button>
</div>
