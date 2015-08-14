<?php 
	require_once("../../controllers/helpers/storedUserInfo.php");
	require_once("../../controllers/helpers/storedActivityInfo.php");
	require_once("../../controllers/triviaController_Validation.php");
	require_once("../../../resources/templates/header.php");
	docheaderWithJqueryLibraries("Open Content Creator - Trivia", "../../../public/css/style.css", "../../../public/img/myicon.ico", array("../../../resources/library/jquery.leanModal.min.js", "../../../public/js/modaltrigger.js", "../../../resources/library/tinymce/tinymce.min.js", "../../../resources/library/tinymce/tinymceConfiguration.js", $dynamicinputfields, "../../../public/js/topscroller.js"));
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
				<h2>Trivia Activity</h2>
				<?php 
					if(isset($_GET['edit']) && isset($_GET['activityNumber'])) 
						echo '<p>Edit the fields to change your activity.</p>';
					else 
						echo '<p>Complete the following fields to create a new activity.</p>';
					
					echo "<div id='filler'></div>";
					if(isset($_POST)) {
						if($triviaTitleError1)
							echo '<p class="activityerror">*Activity Title cannot be empty</p>';
						else if($triviaTitleError2)
							echo '<p class="activityerror">*Activity Title can only have letters, numbers, dashes or spaces</p>';
						else if($triviaTitleError3)
							echo '<p class="activityerror">*Activity Title already exists in database</p>';
						
						if($triviaDescriptionError1)
							echo '<p class="activityerror">*Activity Description cannot be empty</p>';
						else if($triviaDescriptionError2)
							echo '<p class="activityerror">*Activity Description can only have letters, numbers, commas, periods, single quotes or spaces only</p>';
						
						if($triviaImageError1)
							echo '<p class="activityerror">*Title Screen Image cannot be more than 1.5 mb</p>';
						else if($triviaImageError2)
							echo '<p class="activityerror">*Title Screen Image must be either in jpg, png or jpeg format</p>';
						
						
						for($i = 0; $i < 5; $i++) {
							if($triviaQuestionError1[$i]) {
								echo '<p class="activityerror">*Question ' . ($i + 1) . ' cannot be empty</p>';
							}
						}
					
						for($i = 0; $i < 12; $i++) {
							if($triviaQuestionError2[$i]) {
								echo '<p class="activityerror">*Question ' . ($i + 1) . ' can only have letters, numbers, commas, periods, single quotes, question marks, exclamation marks or spaces only</p>';
							}
						}
						
						for($i = 0; $i < 5; $i++) {
							if($triviaCorrectAnswerError1[$i]) {
								echo '<p class="activityerror">*Correct Answer ' . ($i + 1) . ' cannot be empty</p>';
							}
						}
						
						for($i = 0; $i < 12; $i++) {
							if($triviaCorrectAnswerError2[$i]) {
								echo '<p class="activityerror">*Correct ' . ($i + 1) . ' can only have letters, numbers, commas, periods, single quotes, question marks, exclamation marks or spaces only</p>';
							}
						}
						
						for($i = 0; $i < 5; $i++) {
							if($triviaWrongAnswer1Error1[$i]) {
								echo '<p class="activityerror">*Wrong Answer 1 in question ' . ($i + 1) . ' cannot be empty</p>';
							}
						}
						
						for($i = 0; $i < 5; $i++) {
							if($triviaWrongAnswer1Error2[$i]) {
								echo '<p class="activityerror">*Wrong Answer 1 in question ' . ($i + 1) . ' can only have letters, numbers, commas, periods, single quotes, question marks, exclamation marks or spaces only</p>';
							}
						}
						
						for($i = 0; $i < 5; $i++) {
							if($triviaWrongAnswer2Error1[$i]) {
								echo '<p class="activityerror">*Wrong Answer 2 in question ' . ($i + 1) . ' cannot be empty</p>';
							}
						}
						
						for($i = 0; $i < 5; $i++) {
							if($triviaWrongAnswer2Error2[$i]) {
								echo '<p class="activityerror">*Wrong Answer 2 in question ' . ($i + 1) . ' can only have letters, numbers, commas, periods, single quotes, question marks, exclamation marks or spaces only</p>';
							}
						}
						
						for($i = 0; $i < 5; $i++) {
							if($triviaWrongAnswer3Error1[$i]) {
								echo '<p class="activityerror">*Wrong Answer 3 in question ' . ($i + 1) . ' cannot be empty</p>';
							}
						}
						
						for($i = 0; $i < 5; $i++) {
							if($triviaWrongAnswer3Error2[$i]) {
								echo '<p class="activityerror">*Wrong Answer 3 in question ' . ($i + 1) . ' can only have letters, numbers, commas, periods, single quotes, question marks, exclamation marks or spaces only</p>';
							}
						}
						
						for($i = 0; $i < 12; $i++) {
							if($triviaHintError1[$i]) {
								echo '<p class="activityerror">*Hint ' . ($i + 1) . ' can only have letters, numbers, commas, periods, single quotes, question marks, exclamation marks or spaces only</p>';
							}
						}						
						
						echo "<br />";
					}
				?>
			</div>
				<br /><br />
			<div class="activitiesleftcell">
				<div class="userinputfields" style="text-align: right;">
					<p style="font-weight: bold; <?php if($triviaTitleError1 || $triviaTitleError2 || $triviaTitleError3) { echo 'color: #FF0000;'; } ?>">Activity Title: </p>
						<br />
					<p class="nospace" <?php if($triviaDescriptionError1 || $triviaDescriptionError2) { echo 'style="color: #FF0000;"'; } ?>>Activity Description:</p>
						<br /><br />
					<p class="nospace" <?php if($triviaImageError1 || $triviaImageError2) { echo 'style="color: #FF0000;"'; } ?>>Title Screen Image:</p>
						<div class="spacer" style="height: 170px;"></div><br /><br />
					<p class="nospace">Activity Theme Color:</p> 
						<br /><br />
					<p class="nospace">Point Style:</p>
						<br /><br />
					<p class="nospace">Lifelines:</p>
						<div class="spacer" style="height: 100px;"></div><br /><br />
					<p class="nospace" <?php if($triviaOverallQuestionError1 || $triviaOverallQuestionError2 || $triviaOverallCorrectAnswerError1 || $triviaOverallCorrectAnswerError2 || $triviaOverallWrongAnswer1Error1 || $triviaOverallWrongAnswer1Error2 || $triviaOverallWrongAnswer2Error1 || $triviaOverallWrongAnswer2Error2 || $triviaOverallWrongAnswer3Error1 || $triviaOverallWrongAnswer3Error2 || $triviaOverallHintError1) { echo 'style="color: #FF0000;"'; } ?>>Question, Correct & Wrong Answers, Hint:<br /><span class="minimum">(Minimum are 5 questions)</span></p>
						<div class="spacer" style="height: 215px;"></div><br /><br />
					<p class="nospace">Publish Method:</p>
						<div class="spacer" style="height: 20px;"></div><br /><br />
					<p class="nospace">Add Creative Commons License:</p>
						<div class="spacer" style="height: 20px;"></div><br /><br />
					<p class="nospace">Allow the OCC Community to copy this activity:</p>   
				</div>
			</div>
			<div class="activitiesrightcell">
				<div class="userinputfields" style="margin-top: 8px;">
					<input type="text" name="triviaTitle" size="58" value="<?php if(isset($_POST['triviaTitle'])) { echo $_POST['triviaTitle']; } ?>" placeholder="Title must be unique with no duplicate existing" />
						<br /><br />
					<input type="text" name="triviaDescription" size="58" value="<?php if(isset($_POST['triviaDescription'])) { echo $_POST['triviaDescription']; } ?>" placeholder="Short one sentence explanation" />
						<br /><br />
					<div id="uploadPreview"></div><br /><button id="removeImage" class="remove_image">Remove Image</button><br /><br /><input type="hidden" name="triviaTitleImageHidden" id="triviaTitleImageHidden" value="<?php if(isset($_POST['triviaTitleImage'])) { echo $_POST['triviaTitleImage']; } ?>" /><input type="file" name="triviaTitleImage" id="triviaTitleImage" size="20"/><script src="../../../public/js/triviatitleimageupload.js"></script>
						<br /><br />
					<input type="color" name="triviaThemeColor" size="58" value="<?php if(isset($_POST['triviaThemeColor'])) { echo $_POST['triviaThemeColor']; } else { echo "#FF3300"; } ?>" list="colors" />
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
					<input type="radio" name="triviaPointStyle" value="dollars" <?php if(isset($_POST['triviaPointStyle']) && $_POST['triviaPointStyle'] == 'dollars') { echo 'checked="checked"'; } else { echo 'checked="checked"'; } ?>/>Dollars <span class="minimum">($100)</span>
					<input type="radio" name="triviaPointStyle" value="points" <?php if(isset($_POST['triviaPointStyle']) && $_POST['triviaPointStyle'] == 'points') { echo 'checked="checked"'; } ?>/>Points <span class="minimum">(100 Points)</span>	
					<input type="radio" name="triviaPointStyle" value="questions" <?php if(isset($_POST['triviaPointStyle']) && $_POST['triviaPointStyle'] == 'questions') { echo 'checked="checked"'; } ?>/>Questions <span class="minimum">(Question 1)</span>	
						<br /><div class="spacer" style="height: 15px;"></div><br />
					<select name="triviaLifeline5050">
						<?php 
							for($i = 0; $i < 6; $i++) {
								if(isset($_POST['triviaLifeline5050'])) {
									if($_POST['triviaLifeline5050'] == $i)
										echo '<option value="'.$i.'" selected>'.$i.'</option>';
									else
										echo '<option value="'.$i.'">'.$i.'</option>';
								}
								else
									echo '<option value="'.$i.'">'.$i.'</option>';
							}
						?>
					</select>
					50/50 <span class="minimum">(Remove 2 of the wrong answers)</span>
						<br /><br />
					<select name="triviaLifelineHint">
						<?php 
							for($i = 0; $i < 6; $i++) {
								if(isset($_POST['triviaLifelineHint'])) {
									if($_POST['triviaLifelineHint'] == $i)
										echo '<option value="'.$i.'" selected>'.$i.'</option>';
									else
										echo '<option value="'.$i.'">'.$i.'</option>';
								}
								else
									echo '<option value="'.$i.'">'.$i.'</option>';
							}
						?>
					</select>
					Hint <span class="minimum">(Display the hint you will specify for the question)</span>
						<br /><br />
					<select name="triviaLifelineAudience">
						<?php 
							for($i = 0; $i < 6; $i++) {
								if(isset($_POST['triviaLifelineAudience'])) {
									if($_POST['triviaLifelineAudience'] == $i)
										echo '<option value="'.$i.'" selected>'.$i.'</option>';
									else
										echo '<option value="'.$i.'">'.$i.'</option>';
								}
								else
									echo '<option value="'.$i.'">'.$i.'</option>';
							}
						?>
					</select>
					Audience <span class="minimum">(Gives a random bar graph of what people might answer)</span>
						<br /><br />
					<!-- multiform set by user -->
					<div class="steps">
						<fieldset class="input_step_wrap" id="fieldset1">
							<div>
								<select name="triviaDifficulty[]">
									<option value="easy" <?php if(isset($difficulties) && $difficulties[0] == "easy") { echo "selected"; } ?>>Easy</option>
									<option value="medium" <?php if(isset($difficulties) && $difficulties[0] == "medium") { echo "selected"; } ?>>Medium</option>
									<option value="hard" <?php if(isset($difficulties) && $difficulties[0] == "hard") { echo "selected"; } ?>>Hard</option>
								</select>
									<br /><br />
								<input type="text" name="triviaQuestion[]" value="<?php if(isset($questions)) { if($questions[0] != "") { echo $questions[0]; } }?>" size="58" placeholder="Question you want to ask" />
									<br /><br />
								<input type="text" name="triviaCorrectAnswer[]" value="<?php if(isset($correctAnswers)) { if($correctAnswers[0] != "") { echo $correctAnswers[0]; } }?>" size="58" placeholder="Correct answer for the question" />
									<br /><br />
								<input type="text" name="triviaWrongAnswer1[]" value="<?php if(isset($wrongAnswers1)) { if($wrongAnswers1[0] != "") { echo $wrongAnswers1[0]; } }?>" size="14" placeholder="Wrong answer #1" />&nbsp;
								<input type="text" name="triviaWrongAnswer2[]" value="<?php if(isset($wrongAnswers2)) { if($wrongAnswers2[0] != "") { echo $wrongAnswers2[0]; } }?>" size="14" placeholder="Wrong answer #2" />&nbsp;
								<input type="text" name="triviaWrongAnswer3[]" value="<?php if(isset($wrongAnswers3)) { if($wrongAnswers3[0] != "") { echo $wrongAnswers3[0]; } }?>" size="14" placeholder="Wrong answer #3" />
									<br /><br />
								<input type="text" name="triviaHint[]" value="<?php if(isset($hints)) { if($hints[0] != "") { echo $hints[0]; } }?>" size="58" placeholder="Hint for the question (Used as a lifeline. OPTIONAL)" />		
							</div>
						</fieldset>
						<fieldset class="input_step_wrap" id="fieldset2">
							<div>
								<select name="triviaDifficulty[]">
									<option value="easy" <?php if(isset($difficulties) && $difficulties[1] == "easy") { echo "selected"; } ?>>Easy</option>
									<option value="medium" <?php if(isset($difficulties) && $difficulties[1] == "medium") { echo "selected"; } ?>>Medium</option>
									<option value="hard" <?php if(isset($difficulties) && $difficulties[1] == "hard") { echo "selected"; } ?>>Hard</option>
								</select>
									<br /><br />
								<input type="text" name="triviaQuestion[]" value="<?php if(isset($questions)) { if($questions[1] != "") { echo $questions[1]; } }?>" size="58" placeholder="Question you want to ask" />
									<br /><br />
								<input type="text" name="triviaCorrectAnswer[]" value="<?php if(isset($correctAnswers)) { if($correctAnswers[1] != "") { echo $correctAnswers[1]; } }?>" size="58" placeholder="Correct answer for the question" />
									<br /><br />
								<input type="text" name="triviaWrongAnswer1[]" value="<?php if(isset($wrongAnswers1)) { if($wrongAnswers1[1] != "") { echo $wrongAnswers1[1]; } }?>" size="14" placeholder="Wrong answer #1" />&nbsp;
								<input type="text" name="triviaWrongAnswer2[]" value="<?php if(isset($wrongAnswers2)) { if($wrongAnswers2[1] != "") { echo $wrongAnswers2[1]; } }?>" size="14" placeholder="Wrong answer #2" />&nbsp;
								<input type="text" name="triviaWrongAnswer3[]" value="<?php if(isset($wrongAnswers3)) { if($wrongAnswers3[1] != "") { echo $wrongAnswers3[1]; } }?>" size="14" placeholder="Wrong answer #3" />
									<br /><br />
								<input type="text" name="triviaHint[]" value="<?php if(isset($hints)) { if($hints[1] != "") { echo $hints[1]; } }?>" size="58" placeholder="Hint for the question (Used as a lifeline. OPTIONAL)" />		
							</div>
						</fieldset>
						<fieldset class="input_step_wrap" id="fieldset3">
							<div>
								<select name="triviaDifficulty[]">
									<option value="easy" <?php if(isset($difficulties) && $difficulties[2] == "easy") { echo "selected"; } ?>>Easy</option>
									<option value="medium" <?php if(isset($difficulties) && $difficulties[2] == "medium") { echo "selected"; } ?>>Medium</option>
									<option value="hard" <?php if(isset($difficulties) && $difficulties[2] == "hard") { echo "selected"; } ?>>Hard</option>
								</select>
									<br /><br />
								<input type="text" name="triviaQuestion[]" value="<?php if(isset($questions)) { if($questions[2] != "") { echo $questions[2]; } }?>" size="58" placeholder="Question you want to ask" />
									<br /><br />
								<input type="text" name="triviaCorrectAnswer[]" value="<?php if(isset($correctAnswers)) { if($correctAnswers[2] != "") { echo $correctAnswers[2]; } }?>" size="58" placeholder="Correct answer for the question" />
									<br /><br />
								<input type="text" name="triviaWrongAnswer1[]" value="<?php if(isset($wrongAnswers1)) { if($wrongAnswers1[2] != "") { echo $wrongAnswers1[2]; } }?>" size="14" placeholder="Wrong answer #1" />&nbsp;
								<input type="text" name="triviaWrongAnswer2[]" value="<?php if(isset($wrongAnswers2)) { if($wrongAnswers2[2] != "") { echo $wrongAnswers2[2]; } }?>" size="14" placeholder="Wrong answer #2" />&nbsp;
								<input type="text" name="triviaWrongAnswer3[]" value="<?php if(isset($wrongAnswers3)) { if($wrongAnswers3[2] != "") { echo $wrongAnswers3[2]; } }?>" size="14" placeholder="Wrong answer #3" />
									<br /><br />
								<input type="text" name="triviaHint[]" value="<?php if(isset($hints)) { if($hints[2] != "") { echo $hints[2]; } }?>" size="58" placeholder="Hint for the question (Used as a lifeline. OPTIONAL)" />		
							</div>
						</fieldset>
						<fieldset class="input_step_wrap" id="fieldset4">
							<div>
								<select name="triviaDifficulty[]">
									<option value="easy" <?php if(isset($difficulties) && $difficulties[3] == "easy") { echo "selected"; } ?>>Easy</option>
									<option value="medium" <?php if(isset($difficulties) && $difficulties[3] == "medium") { echo "selected"; } ?>>Medium</option>
									<option value="hard" <?php if(isset($difficulties) && $difficulties[3] == "hard") { echo "selected"; } ?>>Hard</option>
								</select>
									<br /><br />
								<input type="text" name="triviaQuestion[]" value="<?php if(isset($questions)) { if($questions[3] != "") { echo $questions[3]; } }?>" size="58" placeholder="Question you want to ask" />
									<br /><br />
								<input type="text" name="triviaCorrectAnswer[]" value="<?php if(isset($correctAnswers)) { if($correctAnswers[3] != "") { echo $correctAnswers[3]; } }?>" size="58" placeholder="Correct answer for the question" />
									<br /><br />
								<input type="text" name="triviaWrongAnswer1[]" value="<?php if(isset($wrongAnswers1)) { if($wrongAnswers1[3] != "") { echo $wrongAnswers1[3]; } }?>" size="14" placeholder="Wrong answer #1" />&nbsp;
								<input type="text" name="triviaWrongAnswer2[]" value="<?php if(isset($wrongAnswers2)) { if($wrongAnswers2[3] != "") { echo $wrongAnswers2[3]; } }?>" size="14" placeholder="Wrong answer #2" />&nbsp;
								<input type="text" name="triviaWrongAnswer3[]" value="<?php if(isset($wrongAnswers3)) { if($wrongAnswers3[3] != "") { echo $wrongAnswers3[3]; } }?>" size="14" placeholder="Wrong answer #3" />
									<br /><br />
								<input type="text" name="triviaHint[]" value="<?php if(isset($hints)) { if($hints[3] != "") { echo $hints[3]; } }?>" size="58" placeholder="Hint for the question (Used as a lifeline. OPTIONAL)" />		
							</div>
						</fieldset>
						<fieldset class="input_step_wrap" id="fieldset5">
							<div>
								<select name="triviaDifficulty[]">
									<option value="easy" <?php if(isset($difficulties) && $difficulties[4] == "easy") { echo "selected"; } ?>>Easy</option>
									<option value="medium" <?php if(isset($difficulties) && $difficulties[4] == "medium") { echo "selected"; } ?>>Medium</option>
									<option value="hard" <?php if(isset($difficulties) && $difficulties[4] == "hard") { echo "selected"; } ?>>Hard</option>
								</select>
									<br /><br />
								<input type="text" name="triviaQuestion[]" id="triviaQuestion5" value="<?php if(isset($questions)) { if($questions[4] != "") { echo $questions[4]; } }?>" size="58" placeholder="Question you want to ask" />
									<br /><br />
								<input type="text" name="triviaCorrectAnswer[]" id="triviaCorrectAnswer5" value="<?php if(isset($correctAnswers)) { if($correctAnswers[4] != "") { echo $correctAnswers[4]; } }?>" size="58" placeholder="Correct answer for the question" />
									<br /><br />
								<input type="text" name="triviaWrongAnswer1[]" id="triviaWrongAnswer1_5" value="<?php if(isset($wrongAnswers1)) { if($wrongAnswers1[4] != "") { echo $wrongAnswers1[4]; } }?>" size="14" placeholder="Wrong answer #1" />&nbsp;
								<input type="text" name="triviaWrongAnswer2[]" id="triviaWrongAnswer2_5" value="<?php if(isset($wrongAnswers2)) { if($wrongAnswers2[4] != "") { echo $wrongAnswers2[4]; } }?>" size="14" placeholder="Wrong answer #2" />&nbsp;
								<input type="text" name="triviaWrongAnswer3[]" id="triviaWrongAnswer3_5" value="<?php if(isset($wrongAnswers3)) { if($wrongAnswers3[4] != "") { echo $wrongAnswers3[4]; } }?>" size="14" placeholder="Wrong answer #3" />
									<br /><br />
								<input type="text" name="triviaHint[]" value="<?php if(isset($hints)) { if($hints[4] != "") { echo $hints[4]; } }?>" size="58" placeholder="Hint for the question (Used as a lifeline. OPTIONAL)" />		
							</div>
						</fieldset>
						<fieldset class="input_step_wrap" id="fieldset6">
							<div>
								<select name="triviaDifficulty[]" id="triviaDifficulty6" disabled>
									<option value="easy" <?php if(isset($difficulties) && $difficulties[5] == "easy") { echo "selected"; } ?>>Easy</option>
									<option value="medium" <?php if(isset($difficulties) && $difficulties[5] == "medium") { echo "selected"; } ?>>Medium</option>
									<option value="hard" <?php if(isset($difficulties) && $difficulties[5] == "hard") { echo "selected"; } ?>>Hard</option>
								</select>
									<br /><br />
								<input type="text" name="triviaQuestion[]" id="triviaQuestion6" value="<?php if(isset($questions)) { if($questions[5] != "") { echo $questions[5]; } }?>" size="58" placeholder="Question you want to ask" disabled/>
									<br /><br />
								<input type="text" name="triviaCorrectAnswer[]" id="triviaCorrectAnswer6" value="<?php if(isset($correctAnswers)) { if($correctAnswers[5] != "") { echo $correctAnswers[5]; } }?>" size="58" placeholder="Correct answer for the question" disabled/>
									<br /><br />
								<input type="text" name="triviaWrongAnswer1[]" id="triviaWrongAnswer1_6" value="<?php if(isset($wrongAnswers1)) { if($wrongAnswers1[5] != "") { echo $wrongAnswers1[5]; } }?>" size="14" placeholder="Wrong answer #1" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer2[]" id="triviaWrongAnswer2_6" value="<?php if(isset($wrongAnswers2)) { if($wrongAnswers2[5] != "") { echo $wrongAnswers2[5]; } }?>" size="14" placeholder="Wrong answer #2" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer3[]" id="triviaWrongAnswer3_6" value="<?php if(isset($wrongAnswers3)) { if($wrongAnswers3[5] != "") { echo $wrongAnswers3[5]; } }?>" size="14" placeholder="Wrong answer #3" disabled/>
									<br /><br />
								<input type="text" name="triviaHint[]" id="triviaHint6" value="<?php if(isset($hints)) { if($hints[5] != "") { echo $hints[5]; } }?>" size="58" placeholder="Hint for the question (Used as a lifeline. OPTIONAL)" disabled/>		
							</div>
						</fieldset>
						<fieldset class="input_step_wrap" id="fieldset7">
							<div>
								<select name="triviaDifficulty[]" id="triviaDifficulty7" disabled>
									<option value="easy" <?php if(isset($difficulties) && $difficulties[6] == "easy") { echo "selected"; } ?>>Easy</option>
									<option value="medium" <?php if(isset($difficulties) && $difficulties[6] == "medium") { echo "selected"; } ?>>Medium</option>
									<option value="hard" <?php if(isset($difficulties) && $difficulties[6] == "hard") { echo "selected"; } ?>>Hard</option>
								</select>
									<br /><br />
								<input type="text" name="triviaQuestion[]" id="triviaQuestion7" value="<?php if(isset($questions)) { if($questions[6] != "") { echo $questions[6]; } }?>" size="58" placeholder="Question you want to ask" disabled/>
									<br /><br />
								<input type="text" name="triviaCorrectAnswer[]" id="triviaCorrectAnswer7" value="<?php if(isset($correctAnswers)) { if($correctAnswers[6] != "") { echo $correctAnswers[6]; } }?>" size="58" placeholder="Correct answer for the question" disabled/>
									<br /><br />
								<input type="text" name="triviaWrongAnswer1[]" id="triviaWrongAnswer1_7" value="<?php if(isset($wrongAnswers1)) { if($wrongAnswers1[6] != "") { echo $wrongAnswers1[6]; } }?>" size="14" placeholder="Wrong answer #1" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer2[]" id="triviaWrongAnswer2_7" value="<?php if(isset($wrongAnswers2)) { if($wrongAnswers2[6] != "") { echo $wrongAnswers2[6]; } }?>" size="14" placeholder="Wrong answer #2" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer3[]" id="triviaWrongAnswer3_7" value="<?php if(isset($wrongAnswers3)) { if($wrongAnswers3[6] != "") { echo $wrongAnswers3[6]; } }?>" size="14" placeholder="Wrong answer #3" disabled/>
									<br /><br />
								<input type="text" name="triviaHint[]" id="triviaHint7" value="<?php if(isset($hints)) { if($hints[6] != "") { echo $hints[6]; } }?>" size="58" placeholder="Hint for the question (Used as a lifeline. OPTIONAL)" disabled/>		
							</div>
						</fieldset>
						<fieldset class="input_step_wrap" id="fieldset8">
							<div>
								<select name="triviaDifficulty[]" id="triviaDifficulty8" disabled>
									<option value="easy" <?php if(isset($difficulties) && $difficulties[7] == "easy") { echo "selected"; } ?>>Easy</option>
									<option value="medium" <?php if(isset($difficulties) && $difficulties[7] == "medium") { echo "selected"; } ?>>Medium</option>
									<option value="hard" <?php if(isset($difficulties) && $difficulties[7] == "hard") { echo "selected"; } ?>>Hard</option>
								</select>
									<br /><br />
								<input type="text" name="triviaQuestion[]" id="triviaQuestion8" value="<?php if(isset($questions)) { if($questions[7] != "") { echo $questions[7]; } }?>" size="58" placeholder="Question you want to ask" disabled/>
									<br /><br />
								<input type="text" name="triviaCorrectAnswer[]" id="triviaCorrectAnswer8" value="<?php if(isset($correctAnswers)) { if($correctAnswers[7] != "") { echo $correctAnswers[7]; } }?>" size="58" placeholder="Correct answer for the question" disabled/>
									<br /><br />
								<input type="text" name="triviaWrongAnswer1[]" id="triviaWrongAnswer1_8" value="<?php if(isset($wrongAnswers1)) { if($wrongAnswers1[7] != "") { echo $wrongAnswers1[7]; } }?>" size="14" placeholder="Wrong answer #1" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer2[]" id="triviaWrongAnswer2_8" value="<?php if(isset($wrongAnswers2)) { if($wrongAnswers2[7] != "") { echo $wrongAnswers2[7]; } }?>" size="14" placeholder="Wrong answer #2" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer3[]" id="triviaWrongAnswer3_8" value="<?php if(isset($wrongAnswers3)) { if($wrongAnswers3[7] != "") { echo $wrongAnswers3[7]; } }?>" size="14" placeholder="Wrong answer #3" disabled/>
									<br /><br />
								<input type="text" name="triviaHint[]" id="triviaHint8" value="<?php if(isset($hints)) { if($hints[7] != "") { echo $hints[7]; } }?>" size="58" placeholder="Hint for the question (Used as a lifeline. OPTIONAL)" disabled/>		
							</div>
						</fieldset>
						<fieldset class="input_step_wrap" id="fieldset9">
							<div>
								<select name="triviaDifficulty[]" id="triviaDifficulty9" disabled>
									<option value="easy" <?php if(isset($difficulties) && $difficulties[8] == "easy") { echo "selected"; } ?>>Easy</option>
									<option value="medium" <?php if(isset($difficulties) && $difficulties[8] == "medium") { echo "selected"; } ?>>Medium</option>
									<option value="hard" <?php if(isset($difficulties) && $difficulties[8] == "hard") { echo "selected"; } ?>>Hard</option>
								</select>
									<br /><br />
								<input type="text" name="triviaQuestion[]" id="triviaQuestion9" value="<?php if(isset($questions)) { if($questions[8] != "") { echo $questions[8]; } }?>" size="58" placeholder="Question you want to ask" disabled/>
									<br /><br />
								<input type="text" name="triviaCorrectAnswer[]" id="triviaCorrectAnswer9" value="<?php if(isset($correctAnswers)) { if($correctAnswers[8] != "") { echo $correctAnswers[8]; } }?>" size="58" placeholder="Correct answer for the question" disabled/>
									<br /><br />
								<input type="text" name="triviaWrongAnswer1[]" id="triviaWrongAnswer1_9" value="<?php if(isset($wrongAnswers1)) { if($wrongAnswers1[8] != "") { echo $wrongAnswers1[8]; } }?>" size="14" placeholder="Wrong answer #1" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer2[]" id="triviaWrongAnswer2_9" value="<?php if(isset($wrongAnswers2)) { if($wrongAnswers2[8] != "") { echo $wrongAnswers2[8]; } }?>" size="14" placeholder="Wrong answer #2" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer3[]" id="triviaWrongAnswer3_9" value="<?php if(isset($wrongAnswers3)) { if($wrongAnswers3[8] != "") { echo $wrongAnswers3[8]; } }?>" size="14" placeholder="Wrong answer #3" disabled/>
									<br /><br />
								<input type="text" name="triviaHint[]" id="triviaHint9" value="<?php if(isset($hints)) { if($hints[8] != "") { echo $hints[8]; } }?>" size="58" placeholder="Hint for the question (Used as a lifeline. OPTIONAL)" disabled/>		
							</div>
						</fieldset>
						<fieldset class="input_step_wrap" id="fieldset10">
							<div>
								<select name="triviaDifficulty[]" id="triviaDifficulty10" disabled>
									<option value="easy" <?php if(isset($difficulties) && $difficulties[9] == "easy") { echo "selected"; } ?>>Easy</option>
									<option value="medium" <?php if(isset($difficulties) && $difficulties[9] == "medium") { echo "selected"; } ?>>Medium</option>
									<option value="hard" <?php if(isset($difficulties) && $difficulties[9] == "hard") { echo "selected"; } ?>>Hard</option>
								</select>
									<br /><br />
								<input type="text" name="triviaQuestion[]" id="triviaQuestion10" value="<?php if(isset($questions)) { if($questions[9] != "") { echo $questions[9]; } }?>" size="58" placeholder="Question you want to ask" disabled/>
									<br /><br />
								<input type="text" name="triviaCorrectAnswer[]" id="triviaCorrectAnswer10" value="<?php if(isset($correctAnswers)) { if($correctAnswers[9] != "") { echo $correctAnswers[9]; } }?>" size="58" placeholder="Correct answer for the question" disabled/>
									<br /><br />
								<input type="text" name="triviaWrongAnswer1[]" id="triviaWrongAnswer1_10" value="<?php if(isset($wrongAnswers1)) { if($wrongAnswers1[9] != "") { echo $wrongAnswers1[9]; } }?>" size="14" placeholder="Wrong answer #1" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer2[]" id="triviaWrongAnswer2_10" value="<?php if(isset($wrongAnswers2)) { if($wrongAnswers2[9] != "") { echo $wrongAnswers2[9]; } }?>" size="14" placeholder="Wrong answer #2" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer3[]" id="triviaWrongAnswer3_10" value="<?php if(isset($wrongAnswers3)) { if($wrongAnswers3[9] != "") { echo $wrongAnswers3[9]; } }?>" size="14" placeholder="Wrong answer #3" disabled/>
									<br /><br />
								<input type="text" name="triviaHint[]" id="triviaHint10" value="<?php if(isset($hints)) { if($hints[9] != "") { echo $hints[9]; } }?>" size="58" placeholder="Hint for the question (Used as a lifeline. OPTIONAL)" disabled/>		
							</div>
						</fieldset>
						<fieldset class="input_step_wrap" id="fieldset11">
							<div>
								<select name="triviaDifficulty[]" id="triviaDifficulty11" disabled>
									<option value="easy" <?php if(isset($difficulties) && $difficulties[10] == "easy") { echo "selected"; } ?>>Easy</option>
									<option value="medium" <?php if(isset($difficulties) && $difficulties[10] == "medium") { echo "selected"; } ?>>Medium</option>
									<option value="hard" <?php if(isset($difficulties) && $difficulties[10] == "hard") { echo "selected"; } ?>>Hard</option>
								</select>
									<br /><br />
								<input type="text" name="triviaQuestion[]" id="triviaQuestion11" value="<?php if(isset($questions)) { if($questions[10] != "") { echo $questions[10]; } }?>" size="58" placeholder="Question you want to ask" disabled/>
									<br /><br />
								<input type="text" name="triviaCorrectAnswer[]" id="triviaCorrectAnswer11" value="<?php if(isset($correctAnswers)) { if($correctAnswers[10] != "") { echo $correctAnswers[10]; } }?>" size="58" placeholder="Correct answer for the question" disabled/>
									<br /><br />
								<input type="text" name="triviaWrongAnswer1[]" id="triviaWrongAnswer1_11" value="<?php if(isset($wrongAnswers1)) { if($wrongAnswers1[10] != "") { echo $wrongAnswers1[10]; } }?>" size="14" placeholder="Wrong answer #1" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer2[]" id="triviaWrongAnswer2_11" value="<?php if(isset($wrongAnswers2)) { if($wrongAnswers2[10] != "") { echo $wrongAnswers2[10]; } }?>" size="14" placeholder="Wrong answer #2" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer3[]" id="triviaWrongAnswer3_11" value="<?php if(isset($wrongAnswers3)) { if($wrongAnswers3[10] != "") { echo $wrongAnswers3[10]; } }?>" size="14" placeholder="Wrong answer #3" disabled/>
									<br /><br />
								<input type="text" name="triviaHint[]" id="triviaHint11" value="<?php if(isset($hints)) { if($hints[10] != "") { echo $hints[10]; } }?>" size="58" placeholder="Hint for the question (Used as a lifeline. OPTIONAL)" disabled/>		
							</div>
						</fieldset>
						<fieldset class="input_step_wrap" id="fieldset12">
							<div>
								<select name="triviaDifficulty[]" id="triviaDifficulty12" disabled>
									<option value="easy" <?php if(isset($difficulties) && $difficulties[11] == "easy") { echo "selected"; } ?>>Easy</option>
									<option value="medium" <?php if(isset($difficulties) && $difficulties[11] == "medium") { echo "selected"; } ?>>Medium</option>
									<option value="hard" <?php if(isset($difficulties) && $difficulties[11] == "hard") { echo "selected"; } ?>>Hard</option>
								</select>
									<br /><br />
								<input type="text" name="triviaQuestion[]" id="triviaQuestion12" value="<?php if(isset($questions)) { if($questions[11] != "") { echo $questions[11]; } }?>" size="58" placeholder="Question you want to ask" disabled/>
									<br /><br />
								<input type="text" name="triviaCorrectAnswer[]" id="triviaCorrectAnswer12" value="<?php if(isset($correctAnswers)) { if($correctAnswers[11] != "") { echo $correctAnswers[11]; } }?>" size="58" placeholder="Correct answer for the question" disabled/>
									<br /><br />
								<input type="text" name="triviaWrongAnswer1[]" id="triviaWrongAnswer1_12" value="<?php if(isset($wrongAnswers1)) { if($wrongAnswers1[11] != "") { echo $wrongAnswers1[11]; } }?>" size="14" placeholder="Wrong answer #1" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer2[]" id="triviaWrongAnswer2_12" value="<?php if(isset($wrongAnswers2)) { if($wrongAnswers2[11] != "") { echo $wrongAnswers2[11]; } }?>" size="14" placeholder="Wrong answer #2" disabled/>&nbsp;
								<input type="text" name="triviaWrongAnswer3[]" id="triviaWrongAnswer3_12" value="<?php if(isset($wrongAnswers3)) { if($wrongAnswers3[11] != "") { echo $wrongAnswers3[11]; } }?>" size="14" placeholder="Wrong answer #3" disabled/>
									<br /><br />
								<input type="text" name="triviaHint[]" id="triviaHint12" value="<?php if(isset($hints)) { if($hints[11] != "") { echo $hints[11]; } }?>" size="58" placeholder="Hint for the question (Used as a lifeline. OPTIONAL)" disabled/>		
							</div>
						</fieldset>
					</div>
					<div id="questionlist">
						<span class="smallbox1"><a href="#" id="question1">1</a></span>
						<span><a href="#" id="question2">2</a></span>
						<span><a href="#" id="question3">3</a></span>
						<span><a href="#" id="question4">4</a></span>
						<span><a href="#" id="question5">5</a></span>
						<span><a href="#" id="question6">6</a></span>
						<span><a href="#" id="question7">7</a></span>
						<span><a href="#" id="question8">8</a></span>
						<span><a href="#" id="question9">9</a></span>
						<span><a href="#" id="question10">10</a></span>
						<span><a href="#" id="question11">11</a></span>
						<span><a href="#" id="question12">12</a></span>
					</div>
						<br /><br />
					<!-- End of multiform set by user -->
					<input type="radio" name="triviaPublishMethod" value="private" <?php if(isset($_POST['triviaPublishMethod']) && ($_POST['triviaPublishMethod'] == "private")) { echo 'checked="checked"'; } else { echo 'checked="checked"'; } ?> /><span>Draft (Cannot be searched or viewed by the public)</span><br />
					<input type="radio" name="triviaPublishMethod" value="public" <?php if(isset($_POST['triviaPublishMethod']) && ($_POST['triviaPublishMethod'] == "public")) { echo 'checked="checked"'; } ?> /><span>Public (Able to be searched and viewed by the public)</span>
						<br /><br />
					<input type="radio" name="triviaCreativeCommon" id="triviaCreativeCommonNo" value="no" <?php if(isset($_POST['triviaCreativeCommon']) && ($_POST['triviaCreativeCommon'] == "no")) { echo 'checked="checked"'; } else { echo 'checked="checked"'; } ?> /><span>No (Attribution - Non Commercial - NoDerivatives 4.0 International)</span><br />
					<input type="radio" name="triviaCreativeCommon" id="triviaCreativeCommonYes" value="yes" <?php if(isset($_POST['triviaCreativeCommon']) && ($_POST['triviaCreativeCommon'] == "yes")) { echo 'checked="checked"'; } ?> /><span>Yes (Attribution - Non Commercial - ShareAlike 4.0 International)</span>			
						<br /><br />
					<input type="radio" name="triviaAllowCopy" id="triviaAllowCopyNo" value="no" <?php if(isset($_POST['triviaAllowCopy']) && ($_POST['triviaAllowCopy'] == "no")) { echo 'checked="checked"'; } else { echo 'checked="checked"'; } if(isset($_POST['triviaCreativeCommon']) && ($_POST['triviaCreativeCommon'] == "no")) { echo " disabled"; } else { echo " disabled"; } ?> /><span>No (Disable from sharing this activity with the OCC community if CCL is set to No)</span><br />
					<input type="radio" name="triviaAllowCopy" id="triviaAllowCopyYes" value="yes" <?php if(isset($_POST['triviaAllowCopy']) && ($_POST['triviaAllowCopy'] == "yes")) { echo 'checked="checked"'; } if(isset($_POST['triviaCreativeCommon']) && ($_POST['triviaCreativeCommon'] == "no")) { echo " disabled"; } ?> /><span>Yes (Disable from sharing this activity with the OCC community if CCL is set to No)</span>											
					<script src="../../../public/js/enablebutton.js"></script>
				</div>
			</div>
		</div>
		<br /><br /><br />
		<input type="submit" name="triviaSubmit" value="Submit Activity" style="width: 400px; height: 40px;"/>
	</form>
	<br /><br /><br /><hr /><br /><div style="text-align: center"><a href="../activityMain/activity.php">Return to homepage</a></div>
<?php 
	require_once("../../../resources/templates/footer.php");
	viewsFooter("../../../public/img/layout/occlogo_bottom.png");
?>