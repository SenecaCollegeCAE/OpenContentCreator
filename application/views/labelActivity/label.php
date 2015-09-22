<?php 
	require_once("../../controllers/helpers/storedUserInfo.php");
	require_once("../../controllers/helpers/storedActivityInfo.php");
	require_once("../../controllers/labelActivityController_Validation.php");
	require_once("../../../resources/templates/header.php");
	docheaderWithJqueryLibraries("Open Content Creator - Label Activity", "../../../public/css/style.css", "../../../public/img/myicon.ico", array("../../../resources/library/jquery.leanModal.min.js", "../../../public/js/modaltrigger.js", "../../../resources/library/tinymce/tinymce.min.js", "../../../resources/library/tinymce/tinymceConfiguration.js", "../../../public/js/dynamiclabelelements.php", "../../../public/js/topscroller.js"));
?>
	
	</head>
	<body>
	<?php
		//Top Navigation bar 
		require_once("../../../resources/templates/navigation.php");
		navigationBody($userInfoArray[1], "../activityMain/");
		require_once("../../../resources/templates/changepassword.php");
		changePassword($userInfoArray[0], $userInfoArray[1], $userInfoArray[3]);
		require_once("../../../resources/templates/help.php");
		helpMenu();
		//End of Top Navigation bar
	?>
	<form name="labelForm" id="labelForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" value="<?php if(isset($_POST['activityNumber'])) { echo $_POST['activityNumber']; } ?>" name="activityNumber" id="activityNumber" />
		<div class="activitiesmaintable">
			<div class="titleblock">
				<h2>Label Activity</h2>
				<?php 
					if(isset($_GET['edit']) && isset($_GET['activityNumber']))
						echo '<p>Edit the fields to change your activity.</p>';
					else
						echo '<p>Complete the following fields to create a new activity.</p>';
					
					echo "<div id='filler'></div>";
					if(isset($_POST)) {
						if($labelTitleError1)
							echo '<p class="activityerror">*Activity Title cannot be empty</p>';
						else if($labelTitleError2)
							echo '<p class="activityerror">*Activity Title can only have letters, numbers, dashes or spaces</p>';
						else if($labelTitleError3)
							echo '<p class="activityerror">*Activity Title already exists in database</p>';
						
						if($labelDescriptionError1)
							echo '<p class="activityerror">*Activity Description cannot be empty</p>';
						else if($labelDescriptionError2)
							echo '<p class="activityerror">*Activity Description can only have letters, numbers, commas, periods, single quotes or spaces only</p>';

						if($labelImageError1)
							echo '<p class="activityerror">*Title Screen Image cannot be more than 1.5 mb</p>';
						else if($labelImageError2)
							echo '<p class="activityerror">*Title Screen Image must be either in jpg, png or jpeg format</p>';
						
						if($labelActivityImageError1)
							echo '<p class="activityerror">*Activity Image is mandatory for activity to work</p>';
						else if($labelActivityImageError2)
							echo '<p class="activityerror">*Activity Image cannot be more than 1.5mb</p>';
						else if($labelActivityImageError3)
							echo '<p class="activityerror">*Activity Image must be either in jpg, png or jpeg format</p>';
						
						for($i = 0; $i < count($labelLabels); $i++) {
							if($labelLabelError1[$i])
								echo '<p class="activityerror">Label Element '. ($i + 1) .' cannot be empty</p>';
							else if($labelLabelError2[$i])
								echo '<p class="activityError">Label Element '. ($i + 1) .' can only have letters, numbers, commas, periods, single quotes, question marks, exclamation marks or spaces only</p>';
						}
						
						echo "<br />";
					}
				?>
			</div>
				<br /><br />
			<div class="activitiesleftcell">
				<div class="userinputfields" style="text-align: right;">
					<p style="font-weight: bold; <?php if($labelTitleError1 || $labelTitleError2 || $labelTitleError3) { echo 'color: #FF0000;'; } ?>">Activity Title: </p>
						<br />
					<p class="nospace" <?php if($labelDescriptionError1 || $labelDescriptionError2) { echo 'style="color: #FF0000;"'; } ?>>Activity Description:</p>
						<br /><br />
					<p class="nospace" <?php if($labelImageError1 || $labelImageError2) { echo 'style="color: #FF0000;"'; } ?>>Title Screen Image:</p>
						<div class="spacer" style="height: 170px;"></div><br /><br />
					<p class="nospace">Activity Theme Color:</p> 
						<div class="spacer" style="height: 20px;"></div><br /><br />
					<p class="nospace" <?php if($labelActivityImageError1 || $labelActivityImageError2 || $labelActivityImageError3) { echo 'style="color: #FF0000;"'; } else { for($i = 0; $i < count($labelLabels); $i++) { if(isset($labelLabels[$i])) { if($labelLabelError1[$i] || $labelLabelError2[$i]) { echo 'style="color: #FF0000;"'; } } } } ?>>Add Label(s) And Image:</p>
					<span class="minimum">(Upload a picture and insert the label locations)</span> 
				</div>
			</div>
			<div class="activitiesrightcell">
				<div class="userinputfields" style="margin-top: 8px;">
					<input type="text" name="labelTitle" size="58" value="<?php if(isset($_POST['labelTitle'])) { echo $_POST['labelTitle']; } ?>" placeholder="Title must be unique with no duplicate existing" />
						<br /><br />
					<input type="text" name="labelDescription" size="58" value="<?php if(isset($_POST['labelDescription'])) { echo $_POST['labelDescription']; } ?>" placeholder="Short one sentence explanation" />
						<br /><br />
					<div id="uploadPreview"></div><br /><button id="removeImage" class="remove_image">Remove Image</button><br /><br /><input type="hidden" name="labelTitleImageHidden" id="labelTitleImageHidden" value="<?php if(isset($_POST['labelTitleImage'])) { echo $_POST['labelTitleImage']; } else if(isset($_POST['labelTitleImageHidden'])) { echo $_POST['labelTitleImageHidden']; } ?>" /><input type="file" name="labelTitleImage" id="labelTitleImage" size="20"/><script src="../../../public/js/labeltitleimageupload.js"></script>
						<br /><br />
					<input type="color" name="labelThemeColor" size="58" value="<?php if(isset($_POST['labelThemeColor'])) { echo $_POST['labelThemeColor']; } else { echo "#FF3300"; } ?>" list="colors" />
					<datalist id="colors">
						<option>#FF3300</option>
						<option>#C8BAFF</option>
						<option>#FFCA61</option>
						<option>#FFA347</option>
						<option>#FF9696</option>
						<option>#70A5FF</option>
						<option>#645EFF</option>
						<option>#FFC591</option>
						<option>#470E00</option>
						<option>#FF2491</option>
						<option>#2E4AFF</option>
						<option>#FF8661</option>
					</datalist>
						<br /><div class="spacer" style="height: 22px;"></div><br />
					<input type="hidden" name="labelActivityImageHidden" id="labelActivityImageHidden" value="<?php if(isset($_POST['labelActivityImage'])) { echo $_POST['labelActivityImage']; } else if(isset($_POST['labelActivityImageHidden'])) { echo $_POST['labelActivityImageHidden']; } ?>" /><input type="file" name="labelActivityImage" id="labelActivityImage" size="20" />
						<br /><br />
					<input type="button" id="CreateLabel" value="Create Label" /> <input type="button" id="UndoLabel" value="Undo Last Step" /> <input type="button" value="console" id="console" />					
				</div>
			</div>
				<br /><br /><br />
			<!--  HTML5 DRAWING CANVAS BEGINNING -->
			<input type="hidden" id="labelPostback" name="labelPostback" value="<?php if(isset($_POST['labelPostback'])) { echo $_POST['labelPostback']; } else { echo "0"; } ?>" />
			<input type="hidden" id="labelCurrentLabel" name="labelCurrentLabel" value="<?php if(isset($_POST['labelCurrentLabel'])) { echo $_POST['labelCurrentLabel']; } ?>" />
			<input type="hidden" id="labelNumOfTimesCreateWasClicked" name="labelNumOfTimesCreateWasClicked" value="<?php if(isset($_POST['labelNumOfTimesCreateWasClicked'])) { echo $_POST['labelNumOfTimesCreateWasClicked']; } ?>" />	
			<input type="hidden" id="labelLabelArray" name="labelLabelArray" value='<?php if(isset($_POST['labelLabelArray'])) { echo $_POST['labelLabelArray']; } ?>' />
			<input type="hidden" id="labelCoordsArray" name="labelCoordsArray" value='<?php if(isset($_POST['labelCoordsArray'])) { echo $_POST['labelCoordsArray']; } ?>' />
			<input type="hidden" id="labelImageTarget" name="labelImageTarget" value='<?php if(isset($_POST['labelImageTarget'])) { echo $_POST['labelImageTarget']; } ?>' />
			<div class="labelCanvas">
				<div class="labelCanvasLeftCell">
					<div class="userinputfields">
						<p class="labelNumber">1. </p><input type="text" name="labelLabel1" id="labelLabel1" maxlength="90" size="25" value="" placeholder="Label 1" />
							<br /><br /><br />
						<span id="parentElement"></span>
					</div>
				</div>
				<div class="labelCanvasRightCell">
					<div class="userinputfields">
						<canvas id="myCanvas" width="650" height="500">Your Browser does not support HTML5</canvas>
					</div>
				</div>
			</div>
			<!--  END OF HTML5 DRAWING CANVAS -->
				<br /><br /><br />
			<div class="activitiesleftcell">
				<div class="userinputfields" style="text-align: right; margin-top: 8px;">
					<p class="nospace">Publish Method:</p>
						<div class="spacer" style="height: 20px;"></div><br /><br />
					<p class="nospace">Add Creative Commons License:</p>
						<div class="spacer" style="height: 20px;"></div><br /><br />
					<p class="nospace">Allow the OCC Community to copy this activity:</p> 
				</div> 
			</div>
			<div class="activitiesrightcell">
				<div class="userinputfields">
					<input type="radio" name="labelPublishMethod" value="private" <?php if(isset($_POST['labelPublishMethod']) && ($_POST['labelPublishMethod'] == "private")) { echo 'checked="checked"'; } else { echo 'checked="checked"'; } ?> /><span>Draft (Cannot be searched or viewed by the public)</span><br />
					<input type="radio" name="labelPublishMethod" value="public" <?php if(isset($_POST['labelPublishMethod']) && ($_POST['labelPublishMethod'] == "public")) { echo 'checked="checked"'; } ?> /><span>Public (Able to be searched and viewed by the public)</span>
						<br /><br />
					<input type="radio" name="labelCreativeCommon" id="labelCreativeCommonNo" value="no" <?php if(isset($_POST['labelCreativeCommon']) && ($_POST['labelCreativeCommon'] == "no")) { echo 'checked="checked"'; } else { echo 'checked="checked"'; } ?> /><span>No (Attribution - Non Commercial - NoDerivatives 4.0 International)</span><br />
					<input type="radio" name="labelCreativeCommon" id="labelCreativeCommonYes" value="yes" <?php if(isset($_POST['labelCreativeCommon']) && ($_POST['labelCreativeCommon'] == "yes")) { echo 'checked="checked"'; } ?> /><span>Yes (Attribution - Non Commercial - ShareAlike 4.0 International)</span>			
						<br /><br />
					<input type="radio" name="labelAllowCopy" id="labelAllowCopyNo" value="no" <?php if(isset($_POST['labelAllowCopy']) && ($_POST['labelAllowCopy'] == "no")) { echo 'checked="checked"'; } else { echo 'checked="checked"'; } if(isset($_POST['labelCreativeCommon']) && ($_POST['labelCreativeCommon'] == "no")) { echo " disabled"; } else { echo " disabled"; } ?> /><span>No (Disable from sharing this activity with the OCC community if CCL is set to No)</span><br />
					<input type="radio" name="labelAllowCopy" id="labelAllowCopyYes" value="yes" <?php if(isset($_POST['labelAllowCopy']) && ($_POST['labelAllowCopy'] == "yes")) { echo 'checked="checked"'; } if(isset($_POST['labelCreativeCommon']) && ($_POST['labelCreativeCommon'] == "no")) { echo " disabled"; } ?> /><span>Yes (Disable from sharing this activity with the OCC community if CCL is set to No)</span>											
					<script src="../../../public/js/enablebutton.js"></script>
				</div>
			</div>
		</div>
		<br /><br /><br />
		<input type="submit" name="labelSubmit" value="Submit Activity" style="width: 400px; height: 40px;"/>
	</form>
	<br /><br /><br /><hr /><br /><div style="text-align: center"><a href="../activityMain/activity.php">Return to homepage</a></div>
<?php 
	require_once("../../../resources/templates/footer.php");
	viewsFooter("../../../public/img/layout/occlogo_bottom.png");
?>