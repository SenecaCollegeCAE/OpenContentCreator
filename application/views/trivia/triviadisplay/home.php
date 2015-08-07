<?php
	session_start();
	require_once("../../../../application/controllers/helpers/storedActivityInfo.php");
	require_once("../../../../application/controllers/helpers/randomizedQuestions.php");
	$randomized = randomizeQuestions($activityObj[9], $activityObj[10], $activityObj[11], $activityObj[12], $activityObj[13], $activityObj[14], $activityObj[15]);
?>
<br />
<div class="triviamainbox"><!--  home -->
	<h1 class="title"><?php echo $activityObj[1]; ?></h1>
	<article><?php echo $activityObj[2]; ?></article>
	<?php 
		if($activityObj[3] != "") {
			echo '<img src="../' . $activityObj[3] . '" />';
			echo '<br /><br /><hr />';
		}
		else 
			echo '<hr />';			
	?>
	<p>Please click the button below to begin this Trivia activity.</p>
	<br />
	<button id="startTrivia" ng-click='startTrivia(<?php echo json_encode($randomized, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)'>Start the Trivia Activity</button>
</div>