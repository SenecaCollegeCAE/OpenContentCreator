<?php
	session_start();
	require_once("../../../../application/controllers/helpers/storedActivityInfo.php");
?>
<div class="labellicense">
	<?php 
		if($activityObj[10] == "yes") {
			if($activityObj[11] == "yes")
				echo '<p style="font-size: 9pt;"><a rel="license" target="_blank" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" /></a>&nbsp;This work is licensed under a <a rel="license" target="_blank" class="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License</a>.</p>';
			else
				echo '<p style="font-size: 9pt;"><a rel="license" target="_blank" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" /></a>&nbsp;This work is licensed under a <a rel="license" target="_blank" class="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License</a>.</p>';
		}
	?>
</div>