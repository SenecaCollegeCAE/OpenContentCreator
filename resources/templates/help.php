<?php 
	function helpMenu() {
		print <<<EOF
		<div id="loginmodal" style="display:none;">
			<a href="#close" name="close" title="close" class="hide_modal">CLOSE</a>
  			<h2>Help</h2>
			<p>(How to use the features in Open Content Creator)</p>
			<ol>
				<li><a href="#search">Search</a></li>
				<li><a href="#changepassword">Change Password</a></li>
				<li><a href="#label">Create Label Activity</a></li>
				<li><a href="#webquest">Create Webquest Activity</a></li>
				<li><a href="#trivia">Create Trivia Activity</a></li>
				<li><a href="#editown">Edit Your Own Activity</a></li>
				<li><a href="#editcopy">Edit A Copied Activity</a></li>
			</ol>
			<br /><hr /><br />
			<div>
				<h2 class="modaltitle">Search</h2>
				<p>In this area on the main page after logging in, type the name of the activity you will like to search and press the search button. (Note that it is only allowed to search for activities that are enable for public viewing by the creator)</p>
				<a href="#close">Back to top</a>
			</div>
			<br /><hr /><br />
		</div>
		
EOF;
	}
?>