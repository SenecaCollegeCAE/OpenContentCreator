<?php
	function navigationBody($userName, $path) {
		$homePath = $path . "activity.php";
		print <<<EOF
		<div id="navigationbar">
			<div id="navigationbarwrapper">
				<div id="navigationcell">
					<span id="navigationtext">Welcome $userName</span>
				</div>
				<div id="navigationcell">
					<a href="$homePath"><img src="../../../public/img/layout/occlogo.png" border="0" /></a>
				</div>
				<div id="navigationcell">
					<div id="navigationspacer"></div>
					<div id="navigationbutton">
						<a href="#changepasswordmodal" rel="triggerModal" class="changepassword"></a>
					</div>
					<div id="navigationbutton">
						<a href="#loginmodal" rel="triggerModal" class="help"></a>
					</div>
					<div id="navigationbutton">
						<a href="../logout.php" class="logout"></a>
					</div>
				</div>
			</div>
		</div>
EOF;
	}
?>