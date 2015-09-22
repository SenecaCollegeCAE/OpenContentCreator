<?php 
	require_once("../../controllers/helpers/storedUserInfo.php");
	require_once("../../controllers/helpers/storedActivityInfo.php");
	require_once("../../controllers/webquestController_Validation.php");
	require_once("../../../resources/templates/header.php");
	docheaderWithJqueryLibraries("Open Content Creator - Webquest", "../../../public/css/style.css", "../../../public/img/myicon.ico", array("../../../resources/library/jquery.leanModal.min.js", "../../../public/js/modaltrigger.js", "../../../resources/library/tinymce/tinymce.min.js", "../../../resources/library/tinymce/tinymceConfiguration.js", $dynamicinputfields, "../../../public/js/topscroller.js"));
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
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" value="<?php if(isset($_POST['activityNumber'])) { echo $_POST['activityNumber']; } ?>" name="activityNumber" id="activityNumber" />
		<div class="activitiesmaintable">
				<div class="titleblock">
					<h2>Webquest Activity</h2>
					<?php 
						if(isset($_GET['edit']) && isset($_GET['activityNumber'])) 
							echo '<p>Edit the fields to change your activity.</p>';
						else 
							echo '<p>Complete the following fields to create a new activity.</p>';
						
						if(isset($_POST)) {
							if($webquestTitleError1)
								echo '<p class="activityerror">*Activity Title cannot be empty</p>';					
							else if($webquestTitleError2)
								echo '<p class="activityerror">*Activity Title can only have letters, numbers, dashes or spaces</p>';
							else if($webquestTitleError3)
								echo '<p class="activityerror">*Activity Title already exists in database</p>';
							
							if($webquestDescriptionError1)
								echo '<p class="activityerror">*Activity Description cannot be empty</p>';
							else if($webquestDescriptionError2)
								echo '<p class="activityerror">*Activity Description can only have letters, numbers, commas, periods, single quotes or spaces only</p>';
							
							if($webquestImageError1)
								echo '<p class="activityerror">*Title Screen Image cannot be more than 1.5 mb</p>';
							else if($webquestImageError2)
								echo '<p class="activityerror">*Title Screen Image must be either in jpg, png or jpeg format</p>';
							
							if($webquestLearningOutcomeError1)
								echo '<p class="activityerror">*Learning Outcomes cannot be empty</p>';
							
							if($webquestOverviewError1)
								echo '<p class="activityerror">*Overview cannot be empty</p>';
							
							//var_dump($webquestLinkErrors1, $webquestTaskErrors1, $webquestQuestionErrors1, $webquestTaskErrors2, $webquestQuestionErrors2);
							
							for($i = 0; $i < count($webquestLinkErrors1); $i++) {
								if($webquestLinkErrors1[$i]) {
									echo '<p class="activityerror">*Link ' . ($i +1) . ' cannot be empty</p>';
								}
							}
							
							for($i = 0; $i < count($webquestTaskErrors1); $i++) {
								if($webquestTaskErrors1[$i]) {
									echo '<p class="activityerror">*Task ' . ($i +1) . ' cannot be empty</p>';
								}
							}
							
							for($i = 0; $i < count($webquestTaskErrors2); $i++) {
								if($webquestTaskErrors2[$i]) {
									echo '<p class="activityerror">*Task ' . ($i +1) . ' can only have letters, numbers, commas, periods, single quotes, question marks, exclamation marks or spaces only</p>';
								}
							}
							
							for($i = 0; $i < count($webquestQuestionErrors1); $i++) {
								if($webquestQuestionErrors1[$i]) {
									echo '<p class="activityerror">*Question ' . ($i +1) . ' cannot be empty</p>';
								}
							}
							
							for($i = 0; $i < count($webquestQuestionErrors2); $i++) {
								if($webquestQuestionErrors2[$i]) {
									echo '<p class="activityerror">*Question ' . ($i +1) . ' can only have letters, numbers, commas, periods, single quotes, question marks, exclamation marks or spaces only</p>';
								}
							}
							
							if($webquestEvaluationError1)
								echo '<p class="activityerror">*Evaluation cannot be empty</p>';
							
							echo "<br />";
						}
					?>
				</div>
					<br /><br />
			<div class="activitiesleftcell">
				<div class="userinputfields" style="text-align: right;">
					<p style="font-weight: bold; <?php if($webquestTitleError1 || $webquestTitleError2 || $webquestTitleError3) { echo 'color: #FF0000;'; } ?>">Activity Title: </p>
						<br />
					<p class="nospace" <?php if($webquestDescriptionError1 || $webquestDescriptionError2) { echo 'style="color: #FF0000;"'; } ?>>Activity Description:</p>
						<br /><br />
					<p class="nospace" <?php if($webquestImageError1 || $webquestImageError2) { echo 'style="color: #FF0000;"'; } ?>>Title Screen Image:</p>
						<div class="spacer" style="height: 170px;"></div><br /><br />
					<p class="nospace">Activity Theme Color:</p> 
						<br /><br />
					<p class="nospace" <?php if($webquestLearningOutcomeError1) { echo 'style="color: #FF0000;"'; } ?>>Learning Outcomes:</p>
						<div class="spacer" style="height: 220px;"></div><br /><br />
					<p class="nospace" <?php if($webquestOverviewError1) { echo 'style="color: #FF0000;"'; } ?>>Overview:</p>
						<div class="spacer" style="height: 215px;"></div><br /><br />
					<p class="nospace" <?php for($i = 0; $i < count($webquestLinkErrors1); $i++) { if($webquestLinkErrors1[$i]) { echo 'style="color: #FF0000;"'; } } for($i = 0; $i < count($webquestTaskErrors1); $i++) { if($webquestTaskErrors1[$i]) { echo 'style="color: #FF0000;"'; }else if($webquestTaskErrors2[$i]) { echo 'style="color: #FF0000;"'; } } for($i = 0; $i < count($webquestQuestionErrors1); $i++) { if($webquestQuestionErrors1[$i]) { echo 'style="color: #FF0000;"'; }else if($webquestQuestionErrors2[$i]) { echo 'style="color: #FF0000;"'; } } ?>>Links, Tasks and Questions:</p>
						<div id="link_spacer"></div><br /><br />
					<p class="nospace" <?php if($webquestEvaluationError1) { echo 'style="color: #FF0000;"'; } ?>>Evaluation:</p>
						<div class="spacer" style="height: 220px;"></div><br /><br />
					<p class="nospace">Publish Method:</p>
						<div class="spacer" style="height: 20px;"></div><br /><br />
					<p class="nospace">Add Creative Commons License:</p>
						<div class="spacer" style="height: 20px;"></div><br /><br />
					<p class="nospace">Allow the OCC Community to copy this activity:</p>    
				</div>
			</div>								
			<div class="activitiesrightcell">
				<div class="userinputfields" style="margin-top: 8px;">
					<input type="text" name="webquestTitle" size="58" value="<?php if(isset($_POST['webquestTitle'])) { echo $_POST['webquestTitle']; } ?>" placeholder="Title must be unique with no duplicate existing" />
						<br /><br />
					<input type="text" name="webquestDescription" size="58" value="<?php if(isset($_POST['webquestDescription'])) { echo $_POST['webquestDescription']; } ?>" placeholder="Short one sentence explanation" />
						<br /><br />
					<div id="uploadPreview"></div><br /><button id="removeImage" class="remove_image">Remove Image</button><br /><br /><input type="hidden" name="webquestTitleImageHidden" id="webquestTitleImageHidden" value="<?php if(isset($_POST['webquestTitleImage'])) { echo $_POST['webquestTitleImage']; } else if(isset($_POST['webquestTitleImageHidden'])) { echo $_POST['webquestTitleImageHidden']; } ?>" /><input type="file" name="webquestTitleImage" id="webquestTitleImage" size="20"/><script src="../../../public/js/webquesttitleimageupload.js"></script>
						<br /><br />
					<input type="color" name="webquestThemeColor" size="58" value="<?php if(isset($_POST['webquestThemeColor'])) { echo $_POST['webquestThemeColor']; } else { echo "#FF3300"; } ?>" list="colors" />
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
						<br /><br />
					<textarea name="webquestLearningOutcomes" class="tinymceTextArea"><?php if(isset($_POST['webquestLearningOutcomes'])) { echo $_POST['webquestLearningOutcomes']; } else { echo "What the particpant should be able to do by the end of the activity"; } ?></textarea>
						<br />
					<textarea name="webquestOverview" class="tinymceTextArea"><?php if(isset($_POST['webquestOverview'])) { echo $_POST['webquestOverview']; } else { echo "Background information that provides context for the learner"; } ?></textarea>
						<br />
					<!-- Dynamically added by user -->
					<div class="input_fields_wrap">
						<button class="add_field_button">Add additional links, tasks and questions to activity</button>
							<br /><br />
						<div>
							<input type="url" name="webquestLink[]" value="<?php if(isset($links)) { $tempLinks = $links; if(array_shift($tempLinks) != "") { echo array_shift($links); } } ?>" size="58" placeholder="Links you want the learner to see" /><br /><br />
							<textarea name="webquestTask[]" placeholder="Task you want the learner to do"><?php if(isset($tasks)) { $tempTasks = $tasks; if(array_shift($tempTasks) != "") { echo array_shift($tasks); } } ?></textarea><br /><br />
							<textarea name="webquestQuestion[]" placeholder="Question(s) you want the learner to answer"><?php if(isset($questions)) { $tempQuestions = $questions; if(array_shift($tempQuestions) != "") { echo array_shift($questions); } } ?></textarea> 
						</div>
					</div>
					<!-- End of dynamically added by user -->
						<br />
					<textarea name="webquestEvaluation" class="tinymceTextArea"><?php if(isset($_POST['webquestEvaluation'])) { echo $_POST['webquestEvaluation']; } else { echo "The evaluation method you will be using to assess the learner"; } ?></textarea>
						<br /><div style="height: 10px;"></div>
					<input type="radio" name="webquestPublishMethod" value="private" <?php if(isset($_POST['webquestPublishMethod']) && ($_POST['webquestPublishMethod'] == "private")) { echo 'checked="checked"'; } else { echo 'checked="checked"'; } ?> /><span>Draft (Cannot be searched or viewed by the public)</span><br />
					<input type="radio" name="webquestPublishMethod" value="public" <?php if(isset($_POST['webquestPublishMethod']) && ($_POST['webquestPublishMethod'] == "public")) { echo 'checked="checked"'; } ?> /><span>Public (Able to be searched and viewed by the public)</span>
						<br /><br />
					<input type="radio" name="webquestCreativeCommon" id="webquestCreativeCommonNo" value="no" <?php if(isset($_POST['webquestCreativeCommon']) && ($_POST['webquestCreativeCommon'] == "no")) { echo 'checked="checked"'; } else { echo 'checked="checked"'; } ?> /><span>No (Attribution - Non Commercial - NoDerivatives 4.0 International)</span><br />
					<input type="radio" name="webquestCreativeCommon" id="webquestCreativeCommonYes" value="yes" <?php if(isset($_POST['webquestCreativeCommon']) && ($_POST['webquestCreativeCommon'] == "yes")) { echo 'checked="checked"'; } ?> /><span>Yes (Attribution - Non Commercial - ShareAlike 4.0 International)</span>			
						<br /><br />
					<input type="radio" name="webquestAllowCopy" id="webquestAllowCopyNo" value="no" <?php if(isset($_POST['webquestAllowCopy']) && ($_POST['webquestAllowCopy'] == "no")) { echo 'checked="checked"'; } else { echo 'checked="checked"'; } if(isset($_POST['webquestCreativeCommon']) && ($_POST['webquestCreativeCommon'] == "no")) { echo " disabled"; } else { echo " disabled"; } ?> /><span>No (Disable from sharing this activity with the OCC community if CCL is set to No)</span><br />
					<input type="radio" name="webquestAllowCopy" id="webquestAllowCopyYes" value="yes" <?php if(isset($_POST['webquestAllowCopy']) && ($_POST['webquestAllowCopy'] == "yes")) { echo 'checked="checked"'; } if(isset($_POST['webquestCreativeCommon']) && ($_POST['webquestCreativeCommon'] == "no")) { echo " disabled"; } ?> /><span>Yes (Disable from sharing this activity with the OCC community if CCL is set to No)</span>											
					<script src="../../../public/js/enablebutton.js"></script>
				</div>
			</div>
		</div>
		<br /><br /><br />
		<input type="submit" name="webquestSubmit" value="Submit Activity" style="width: 400px; height: 40px;"/>
	</form>
	<br /><br /><br /><hr /><br /><div style="text-align: center"><a href="../activityMain/activity.php">Return to homepage</a></div>
<?php 
	require_once("../../../resources/templates/footer.php");
	viewsFooter("../../../public/img/layout/occlogo_bottom.png");
?>