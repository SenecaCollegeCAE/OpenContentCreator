<?php
	session_start();
	require_once("../../../../application/controllers/helpers/storedActivityInfo.php");
?>
<br />
<div class="labelTable"><!-- label start -->
	<div class="labelleftbox">
		<h3>Match the label to the number below:</h3>
		<?php 
			for($i = 0; $i < count($activityObj[6]); $i++) {
				echo "<p>" . ($i + 1) . ") " . $activityObj[6][$i] . "</p>";
			}				
		?>
	</div>
	<div class="labelrightbox">
		<div ng-init="init()"></div>
		<br />
		<h3 id="statusText">Drag the label number to the correct area.</h3>
		<br /><br />
		<div id="container"></div><!-- Used for the label dragging activity / area -->
	</div>
</div>
