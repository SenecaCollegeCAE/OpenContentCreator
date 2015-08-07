<?php
	session_start();
	require_once("../../../../application/controllers/helpers/storedActivityInfo.php");
?>
<div class="webquestmainbox"><!-- home -->
	<h1 class="title"><?php echo $activityObj[1]; ?></h1>
	<article><?php echo $activityObj[2]; ?></article>
	<br /><br />
	<?php 
		if($activityObj[3] != "") {
			echo '<img src="../' . $activityObj[3] . '" />';
			echo '<br /><br /><hr />';
		}
		else 
			echo '<hr />';			
	?>
	<p>Please click the tabs above to navigate this webquest activity.</p>
</div>
