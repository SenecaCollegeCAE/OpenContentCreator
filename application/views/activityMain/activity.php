<?php 
	require_once("../../controllers/helpers/storedUserInfo.php");
	require_once("../../controllers/activityMainPageController_Validation.php");
	require_once("../../../resources/templates/header.php");
	docheaderWithJqueryLibraries("Open Content Creator - Home", "../../../public/css/style.css", "../../../public/img/myicon.ico", array("../../../resources/library/jquery.leanModal.min.js", "../../../public/js/modaltrigger.js"));
?>
	</head>
	<body>
		<?php
			if(isset($_GET['submit']) && $_GET['submit'] == "yes") //Pops up when user submits successful data from the activity forms
				echo "<script src='../../../public/js/submitsuccess.js'></script>";
			
			//Top Navigation bar 
			require_once("../../../resources/templates/navigation.php");
			navigationBody($userInfoArray[1], "./");
			require_once("../../../resources/templates/changepassword.php");
			changePassword($userInfoArray[0], $userInfoArray[1], $userInfoArray[3]);
			require_once("../../../resources/templates/help.php");
			helpMenu();
			//End of Top Navigation bar
		?>
		<div class="maintable">
			<div class="leftcell">
				<h2>Create A Brand New Activity</h2>
				<div class="leftcell1">
					<a href="../webquest/webquest.php"><div class="activityWebquest"></div></a>
						<br /><br />
					<a href="../trivia/trivia.php"><div class="activityTrivia"></div></a>
						<br /><br />
					<a href="../labelActivity/label.php"><div class="activityLabel"></div></a>
				</div>
				<div class="leftcell2">
					<p>An inquiry-oriented lesson format in which most or all the information that learners work with comes from the internet. Uses internet resources, which encourage students to use higher order thinking skills to solve a real difficult problem.</p>
						<div class="spacer"></div>
					<p>A trivial game or competition where one of the competitors(students) are asked questions created by the professor about interesting but unimportant facts in many subjects.</p>
						<div class="spacer"></div>
					<p>A drag and drop learning interactive activity for the user to name the parts within a picture.</p>
				</div>
			</div>
			<div class="rightcell">
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					<h2>Search Activity</h2>
					<p>Type an activity name to search for all public OCC activities.</p>
					<input type="text" size="30" name="activitySearch" /> &nbsp;<input type="submit" name="activitySearchSubmit" value="Search" style="margin-top: -5px;"/>
					<?php 
						if(isset($_POST['activitySearchSubmit'])) {
							if($searchError1)
								echo '<div class="activityerrormsg">*Search cannot be empty</div>';
							else if($searchError2)
								echo '<div class="activityerrormsg">*Search did not have any results</div>';
						}
					?>
						<br /><br />
					<h2>Make A Copy Of Your Own Activity</h2>
					<p>Please choose an activity to make a copy of. For convenience, please rename the activity right away.</p>
					<select name="activitySelfCopy" class="length">
						<option value="0">Select activity to copy</option>
						<?php 
							//Get user activity from database for the user currently logined
						?>
					</select> &nbsp;<input type="submit" name="activitySelfCopySubmit" value="Copy" style="margin-top: -5px;" />
						<br /><br />
					<h2>View And Edit Activity</h2>
					<p>View and edit an activity that you have created.</p>
					<select name="activityViewEdit" class="length">
						<option value="0">Select activity to view and edit</option></body>
						<?php 
							//get user activity created by the user from database
							$allActivitiesCreatedByUserKeys = array_keys($allActivitiesCreatedByUser);
							for($i = 0; $i < count($allActivitiesCreatedByUser); $i++) {
								echo "<option value='" . $allActivitiesCreatedByUserKeys[$i] . "'>" . $allActivitiesCreatedByUser[$allActivitiesCreatedByUserKeys[$i]] . "</option>"; 
							}
						?>
					</select> &nbsp;<input type="submit" name="activityViewEditSubmit" value="View & Edit" style="margin-top: -5px;" />
						<br /><br />
					<h2>View And Edit Copied Activity</h2>
					<p>View and edit an activity that you have copied from the OCC community.</p>
					<select name="activityCopyViewEdit" class="length">
						<option value="0">Select activity to view and edit</option></body>
						<?php 
							//get user copied activity created by other users from database
						?>
					</select> &nbsp;<input type="submit" name="activityCopyViewEditSubmit" value="View & Edit" style="margin-top: -5px;" />
				</form>
			</div>
		</div>
		<br /><br /><hr /><br />
<?php 
	require_once("../../../resources/templates/footer.php");
	viewsFooter("../../../public/img/layout/occlogo_bottom.png");
?>