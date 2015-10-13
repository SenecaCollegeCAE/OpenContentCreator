<?php
	require_once("../controllers/searchController_Validation.php"); 
	require_once("../../resources/templates/header.php");
	docheader("Open Content Creator - Search Activity", "../../public/css/style.css", "../../public/img/myicon.ico");
?>
	</head>
	<body>
		<div id="logoplacement">
			<a href="../../index.php"><img src="../../public/img/layout/occlogo.png" border="0" /></a>
		</div>
		<div class="searchbox">
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
				<fieldset class="searchbox">
					<legend class="searchbox">Search Activity</legend>
					<input type="text" size="47" name="searchActivity" />
					<input type="submit" name="searchSubmit" value="Search Activity" style="margin-top: -5px;"/>
					<?php 
						if(isset($_POST['searchActivity']))
							if($searchError1)
								echo '<div class="searcherrormsg">*Search cannot be empty.';
							else {
								echo '<br /><h3>Search for &quot;'. $_POST['searchActivity'] . '&quot; Result:</h3><br />';
								
								if($searchError2)
									echo '<h2>Search did not return any results.</h2>';
								else
									echo "<hr /><br />". $searchResults;
							}
					?>
					<br /><br /><br />
		    			<a href="../../index.php" style="font-weight: bold; margin-left: 195px;">Return to homepage</a>
					<br /><br />
				</fieldset>
			</form>
		</div>
<?php
	require_once("../../resources/templates/footer.php");
	viewsFooter("../../public/img/layout/occlogo_bottom.png");
?>