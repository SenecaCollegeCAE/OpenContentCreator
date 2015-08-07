<?php
	session_start();
	require_once("../../../../application/controllers/helpers/storedActivityInfo.php");
?>
<div class="webquestmainbox" style="text-align: left;"><!-- links -->
	<div class="activityspace"></div>
	<h2 class="title">Links</h2>
	<div class="linkbackground">
		<?php 
			for($i = 0; $i < count($activityObj[7]); $i++)
				echo '<span class="link" ng-click="changeLink(' . ($i + 1) . ')">' . ($i + 1) . '</span> &nbsp;';
		?>
	</div>
	<?php 
		for($i = 0; $i < count($activityObj[7]); $i++) {
			echo '<div class="linksTasksQuestions" ng-if="link == ' . ($i + 1) . '">';
				echo '<h3>Link #' . ($i + 1) . "</h3>";
			
				if(strlen($activityObj[7][$i]) > 48)
					$url = substr($activityObj[7][$i], 0, 48) . "...";
				
				else
					$url = $activityObj[7][$i];
									
				echo '<div>Follow this link: &nbsp;<span class="links"><a href="' . $activityObj[7][$i] . '" target="_blank">' . $url . '</a></span></div>';
				echo '<br />';
				echo '<div class="tasks">';
					echo '<p>' . nl2br($activityObj[8][$i]) . '</p>';
				echo '</div>';
				echo '<div class="questions">';
					echo '<p>' . nl2br($activityObj[9][$i]) . '</p>';
				echo '</div>';
			echo '</div>';
		}
	?>
</div>
