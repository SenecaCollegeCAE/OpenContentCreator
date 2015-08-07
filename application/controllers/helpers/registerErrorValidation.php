<?php
	function registerErrorValidation() {
		if(isset($_POST['regUname'])) {
			if($_POST['regUname'] == "") {
				print <<<EOF
				<div class="registererrormsg">*Username cannot be empty</div>		
EOF;
			}
		}
		else
			return "HA";
	}
?>