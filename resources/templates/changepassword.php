<?php 
	function changePassword($userId, $userName, $cryptPassword) {
		$action = htmlspecialchars($_SERVER['PHP_SELF']);
		
		print <<<EOF
		<div id="changepasswordmodal" style="display:none;">
			<a href="#close" name="close" title="close" class="hide_modal">CLOSE</a>
  			<h2>Change Password</h2>
			
				<input type="hidden" name="chgUserId" id="chgUserId" value="$userId" />
				<input type="hidden" name="chgUserName" id="chgUserName" value="$userName" />
				<input type="hidden" name="chgCryptPassword" id="chgCryptPassword" value="$cryptPassword" />
				<label for="username">Username: <span style="font-weight: bold;" id="chgUsername">$userName</span></label>
				<br /><br />
				<label for="oldpassword">Old Password: </label>
				<input type="password" name="chgOldPassword" id="chgOldPassword" size="50" class="labelfield" />
				<div class="forgotpassworderrormsg2" id="oldPasswordError1"></div>
				<div class="forgotpassworderrormsg2" id="oldPasswordError2"></div>

				<label for="newpassword">New Password: </label>
				<input type="password" name="chgNewPassword" id="chgNewPassword" size="50" class="labelfield" />
				<div class="forgotpassworderrormsg3" id="newPasswordError1"></div>
				<div class="forgotpassworderrormsg3" id="newPasswordError2"></div>

				<label for="repeatpassword">Repeat Password: </label>
				<input type="password" name="chgRepeatPassword" id="chgRepeatPassword" size="50" class="labelfield" />
				<div class="forgotpassworderrormsg4" id="repeatPasswordError1"></div>

				<br />
				<input type="submit" name="changepasswordbtn" id="changepasswordbtn" value="Change Password">
				<br />
				<h2 id="passwordChangeMessage"></h2>
		</div>
EOF;
	}
?>